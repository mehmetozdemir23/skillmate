<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display the specified user's profile.
     *
     * @param \App\Models\User $user The user to show the profile for
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(User $user): RedirectResponse|View
    {
        $authUser = Auth::user();

        if ($user->id == $authUser->id) {
            return redirect()->route('profile.show');
        }

        $services = $user->services()->with('reviews')->get();

        return view('pages.users.show', compact('user','services'));
    }
}