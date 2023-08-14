<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile
     */
    public function show(): View
    {
        $user = Auth::user();
        return view('pages.profile.show', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateInfo(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'regex:/^[A-Za-z\s]+$/', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return back()->with('success', 'Profile information updated successfully.');
    }

    /**
     * Update the user's avatar.
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => 'required|image',
        ]);

        $uploadedFile = $request->file('avatar');
        $avatarName = $uploadedFile->hashName();

        $uploadedFile->storeAs('avatars', $avatarName, 'public');

        $user = Auth::user();

        if ($user->avatar != 'default-avatar.svg') {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }
        $user->avatar = $avatarName;
        $user->save();

        return back()->with('success', 'Avatar updated successfully.');
    }

    /**
     * Delete the user's avatar.
     */
    public function deleteAvatar(): RedirectResponse
    {
        $user = Auth::user();

        Storage::disk('public')->delete('avatars/' . $user->avatar);

        $user->avatar = null;
        $user->save();

        return back()->with('success', 'Avatar deleted successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function deleteAccount(Request $request): RedirectResponse
    {
        // $request->validateWithBag('userDeletion', [
        //     'password' => ['required', 'current_password'],
        // ]);


        $user = $request->user();
        if ($user->avatar != 'default-avatar.svg') {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
