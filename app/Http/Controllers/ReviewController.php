<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Display the review creation form.
     *
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\View\View
     */
    public function create(Mission $mission): View
    {
        return view('pages.reviews.create', compact('mission'));
    }

    /**
     * Store a new review for a mission.
     *
     * @param  \App\Models\Mission  $mission
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Mission $mission, Request $request): RedirectResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        Review::create([
            'mission_id' => $mission->id,
            'reviewer_id' => $user->id,
            'comment' => $request->get('comment'),
            'rating' => $request->get('rating'),
        ]);

        return back();
    }
}
