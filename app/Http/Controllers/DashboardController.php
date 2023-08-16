<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        $proposedServicesCount = $user->services()->count();
        $pendingServiceRequestsCount = $user->receivedServiceRequests()->count();
        $completedMissionsCount = $user->missions()->where('status', 'completed')->count();
        $onGoingMissionsCount = $user->missions()->where('status', 'in_progress')->count();

        return view(
            'pages.dashboard',
            compact(
                'proposedServicesCount',
                'pendingServiceRequestsCount',
                'completedMissionsCount',
                'onGoingMissionsCount'
            )
        );
    }
}