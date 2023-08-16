<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    /**
     * Display the service requests sent by the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
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

    /**
     * Display the service requests received by the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function receivedServiceRequests(Request $request): View
    {
        $request->validate([
            'sort-by-column' => 'nullable|string|in:sender,services.title,created_at,status',
            'order' => 'nullable|string|in:asc,desc',
        ]);

        $user = Auth::user();
        $sortByColumn = 'created_at';
        $sortOrder = 'asc';
        $receivedServiceRequests = $user->receivedServiceRequests();

        if ($request->filled('sort-by-column') && $request->filled('order')) {
            $sortByColumn = $request->get('sort-by-column');
            $sortOrder = $request->get('order');

            if ($sortByColumn == 'sender') {
                $receivedServiceRequests->join('users', 'service_requests.sender_id', '=', 'users.id')
                    ->select(['users.name', 'service_requests.*'])
                    ->orderBy('users.name', $sortOrder);
            } else if ($sortByColumn == 'services.title') {
                $receivedServiceRequests->select(['services.title', 'service_requests.*'])
                    ->orderBy('services.title', $sortOrder);
            } else {
                $receivedServiceRequests->orderBy($sortByColumn, $sortOrder);
            }

            $sortOrder = $sortOrder == 'asc' ? 'desc' : 'asc';
        }

        $receivedServiceRequests = $receivedServiceRequests->get();

        return view('pages.service_requests.received', compact('receivedServiceRequests', 'sortOrder'));
    }

    /**
     * Display the service request creation form.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\View\View
     */
    public function create(Service $service): View
    {
        $requestedService = $service;
        $requestSender = Auth::user();
        $requestReceiver = $service->user;

        return view('pages.service_requests.create', compact(['requestSender', 'requestReceiver', 'requestedService']));
    }

    /**
     * Display the details of a service request.
     *
     * @param  \App\Models\Service  $service
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\View\View
     */
    public function show(Service $service, ServiceRequest $serviceRequest): View
    {
        return view('pages.service_requests.show', compact('serviceRequest'));
    }

    /**
     * Store a new service request.
     *
     * @param  \App\Models\Service  $service
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Accept a service request.
     *
     * @param  \App\Models\Service  $service
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Decline a service request.
     *
     * @param  \App\Models\Service  $service
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function decline(Service $service, ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->status = 'declined';
        $serviceRequest->save();

        return redirect()->route('serviceRequests.received');
    }

    /**
     * Undo the status change of a service request.
     *
     * @param  \App\Models\Service  $service
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function undo(Service $service, ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->status = 'pending';
        $serviceRequest->save();

        return back();
    }

    /**
     * Delete a service request.
     *
     * @param  \App\Models\Service  $service
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Service $service, ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->delete();

        return back();
    }
}