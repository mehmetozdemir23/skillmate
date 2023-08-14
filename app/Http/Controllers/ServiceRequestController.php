<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    /*
    public function serviceRequestsSent(Request $request): View
    {
        $request->validate([
            'sortColumn' => 'nullable|string|in:receiver,services.title,created_at,status',
            'sortOrder' => 'nullable|string|in:asc,desc',
        ]);

        $user = Auth::user();
        $sortColumn = 'receiver';
        $sortOrder = 'asc';
        $serviceRequestsSent = $user->serviceRequestsSent()->with(['receiver','service']);
         

        if ($request->filled('sortColumn') && $request->filled('sortOrder')) {
            $sortColumn = $request->get('sortColumn');
            $sortOrder = $request->get('sortOrder');

            if ($request->sortColumn == 'receiver') {
                $serviceRequestsSent->join('services', 'service_requests.service_id', '=', 'services.id')->select('services.user_id')
                ->join('users','services.user_id','=','users.id')->select(['users.name', 'service_requests.*'])->orderBy('users.name', $sortOrder);
            } else {
                $serviceRequestsSent->orderBy($sortColumn, $sortOrder);
            }

            $sortOrder = $sortOrder === 'asc' ? 'desc' : 'asc';
        }

        $serviceRequestsSent = $serviceRequestsSent->get();

        return view('pages.service_requests.sent', compact('serviceRequestsSent', 'sortOrder'));
    }

    public function serviceRequestsReceived(Request $request): View
    {
        $request->validate([
            'sortColumn' => 'nullable|string|in:users.name,services.title,created_at,status',
            'sortOrder' => 'nullable|string|in:asc,desc',
        ]);

        $user = Auth::user();
        $serviceRequestsReceived = ServiceRequest::whereHas('service', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });

        $serviceRequestsReceived->with('sender');

        $sortColumn = 'users.name';
        $sortOrder = 'asc';

        if ($request->filled('sortColumn') && $request->filled('sortOrder')) {
            $sortColumn = $request->get('sortColumn');
            $sortOrder = $request->get('sortOrder');

            if ($sortColumn == 'users.name') {
                $serviceRequestsReceived->join('users', 'service_requests.user_id', '=', 'users.id');
            } else if ($sortColumn == 'services.title') {
                $serviceRequestsReceived->join('services', 'service_requests.service_id', '=', 'services.id');
            }

            $serviceRequestsReceived->orderBy($request->get('sortColumn'), $request->get('sortOrder'))
                ->select('service_requests.*');

            $sortOrder = $sortOrder == 'asc' ? 'desc' : 'asc';
        }

        $serviceRequestsReceived = $serviceRequestsReceived->get();

        return view('pages.service_requests.received', compact('serviceRequestsReceived', 'sortOrder'));
    }*/
    public function sentServiceRequests(Request $request): View
    {
        $request->validate([
            'sort-by-column' => 'nullable|string|in:receiver,services.title,created_at,status',
            'order' => 'nullable|string|in:asc,desc',
        ]);

        $user = Auth::user();
        $sortByColumn = 'created_at';
        $sortOrder = 'asc';
        $sentServiceRequests = $user->sentServiceRequests();

        if ($request->filled('sort-by-column') && $request->filled('order')) {
            $sortByColumn = $request->get('sort-by-column');
            $sortOrder = $request->get('order');

            if ($sortByColumn == 'receiver') {
                $sentServiceRequests->join('services', 'service_requests.service_id', '=', 'services.id')
                    ->select('services.user_id')
                    ->join('users', 'services.user_id', '=', 'users.id')
                    ->select(['users.name', 'service_requests.*'])->orderBy('users.name', $sortOrder);
            } else if ($sortByColumn == 'services.title') {
                $sentServiceRequests->join('services', 'service_requests.service_id', '=', 'services.id')
                    ->select(['services.title', 'service_requests.*'])->orderBy('services.title', $sortOrder);
            } else {
                $sentServiceRequests->orderBy($sortByColumn, $sortOrder);
            }

            $sortOrder = $sortOrder == 'asc' ? 'desc' : 'asc';
        }

        $sentServiceRequests = $sentServiceRequests->get();

        return view('pages.service_requests.sent', compact('sentServiceRequests', 'sortOrder'));
    }

    public function receivedServiceRequests(Request $request): View
    {
        $sortByColumn = $request->get('sort-by-column') ?? 'created_at';
        $sortOrder = $request->get('order') ?? 'asc';

        $user = Auth::user();
        $receivedServiceRequests = $user->receivedServiceRequests();

        $receivedServiceRequests->orderBy($sortByColumn, $sortOrder);
        $sortOrder = $sortOrder == 'asc' ? 'desc' : 'asc';

        $receivedServiceRequests = $receivedServiceRequests->get();

        return view('pages.service_requests.received', compact('receivedServiceRequests', 'sortOrder'));
    }

    public function create(Service $service): View
    {
        $requestedService = $service;
        $requestSender = Auth::user();
        $requestReceiver = $service->user;

        return view('pages.service_requests.create', compact(['requestSender', 'requestReceiver', 'requestedService']));
    }

    public function show(Service $service, ServiceRequest $serviceRequest): View
    {
        return view('pages.service_requests.show', compact('serviceRequest'));
    }

    public function store(Service $service, Request $request): RedirectResponse
    {
        $user = Auth::user();

        ServiceRequest::create([
            'sender_id' => $user->id,
            'service_id' => $service->id,
            'notes' => $request->notes
        ]);

        return redirect()->route('serviceRequests.sent');
    }

    public function accept(Service $service, ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->status = 'accepted';
        $serviceRequest->save();

        Mission::create([
            'service_id' => $serviceRequest->service->id,
            'receiver_id' => $serviceRequest->sender->id
        ]);

        return redirect()->route('serviceRequests.received');
    }

    public function decline(Service $service, ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->status = 'declined';
        $serviceRequest->save();

        return redirect()->route('serviceRequests.received');
    }

    public function undo(Service $service, ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->status = 'pending';
        $serviceRequest->save();

        return back();
    }

    public function destroy(Service $service, ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->delete();

        return back();
    }
}
