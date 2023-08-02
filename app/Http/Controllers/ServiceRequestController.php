<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
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
    }

    public function create(Request $request): View
    {
        $requestedService = Service::find($request->service_id);
        $requestSender = Auth::user();
        $requestReceiver = User::find($request->receiver_id);
        return view('pages.service_requests.create', compact(['requestSender', 'requestReceiver', 'requestedService']));
    }

    public function store(Request $request): RedirectResponse
    {
        ServiceRequest::create([
            'user_id' => Auth::user()->id,
            'service_id' => $request->service_id,
            'notes' => $request->notes
        ]);

        return redirect()->route('serviceRequests.sent');
    }

    public function show(ServiceRequest $serviceRequest): View
    {
        return view('pages.service_requests.show', compact('serviceRequest'));
    }

    public function accept(ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->status = 'accepted';
        $serviceRequest->save();

        return redirect()->route('serviceRequests.index');
    }

    public function decline(ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->status = 'declined';
        $serviceRequest->save();

        return redirect()->route('serviceRequests.received');
    }

    public function undo(ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->status = 'pending';
        $serviceRequest->save();

        return back();
    }

    public function destroy(ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->delete();
        
        return back();
    }
}
