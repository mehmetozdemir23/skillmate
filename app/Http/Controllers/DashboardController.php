<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();
        $proposedServicesCount = $user->services()->count();
        $pendingServiceRequestsCount = $user->receivedServiceRequests()->count();
        $completedMissionsCount = $user->missions()->where('status','completed')->count();
        $onGoingMissionsCount = $user->missions()->where('status','in_progress')->count();

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
