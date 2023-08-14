<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\ServiceRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    public function index(Request $request): View
    {
        $request->validate([
            'filter-by-type' => 'nullable|string|in:proposed,received',
            'filter-by-status' => 'nullable|string|in:pending,in_progress,completed',
            'sort_by_date' => 'nullable|string|in:newest,oldest'
        ]);

        $user = Auth::user();

        $filterByType = $request->get('filter-by-type');

        if ($filterByType == 'received') {
            $missions = $user->receivedMissions();
        } else {
            $missions = $user->missions();
        }

        $missions = $missions->with(['service.skill', 'review']);

        $filterByStatus = $request->get('filter-by-status');
        if ($filterByStatus) {
            $missions->where('status', $filterByStatus);
        }

        $sortOrder = $request->input('sort-by-date', 'newest') == 'newest' ? 'asc' : 'desc';
        $missions->orderBy('created_at', $sortOrder);

        $missions = $missions->get();
        $statuses = ['pending', 'in_progress', 'completed'];

        return view('pages.missions.index', compact('missions', 'statuses'));
    }

    public function start(Mission $mission): RedirectResponse
    {
        $mission->status = 'in_progress';
        $mission->save();

        $serviceRequest = ServiceRequest::whereHas('service', function ($query) use ($mission) {
            $query->where('services.id', $mission->service->id);
        })->first();

        $serviceRequest->delete();

        return redirect()->route('missions.index');
    }

    public function end(Mission $mission): RedirectResponse
    {
        $mission->status = 'completed';
        $mission->save();

        return redirect()->route('missions.index');
    }
}
