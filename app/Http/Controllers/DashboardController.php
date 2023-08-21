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
        $missionCounts = $user->missions()
            ->selectRaw('status, count(*) as count')
            ->whereIn('status', ['completed', 'in_progress'])
            ->groupBy('services.user_id','status')
            ->get();

        $completedMissionsCount = 0;
        $onGoingMissionsCount = 0;

        foreach ($missionCounts as $count) {
            if ($count->status === 'completed') {
                $completedMissionsCount = $count->count;
            } elseif ($count->status === 'in_progress') {
                $onGoingMissionsCount = $count->count;
            }
        }
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