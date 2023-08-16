<?php

namespace App\Http\Controllers;

use App\Models\Skill;
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
     * Display the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        $user = Auth::user();
        return view('pages.profile.show', compact('user'));
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
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
     *
     * @return \Illuminate\Http\RedirectResponse
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
     * Display the form to add a skill.
     *
     * @return \Illuminate\View\View
     */
    public function addSkillForm(): View
    {
        $user = Auth::user();
        $selectedSkillIds = $user->skills->pluck('id')->toArray();
        $skills = Skill::whereNotIn('id', $selectedSkillIds)->get();

        return view('pages.profile.add-skill-form', compact('skills'));
    }

    /**
     * Store a new skill for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSkill(Request $request): RedirectResponse
    {
        $request->validate([
            'skill_id' => 'required|exists:skills,id'
        ]);

        $user = Auth::user();
        $skill = Skill::find($request->get('skill_id'));

        $user->skills()->save($skill);

        return redirect()->route('profile.show')->with('success', 'New skill added successfully.');
    }

    /**
     * Delete a skill for the user.
     *
     * @param  \App\Models\Skill  $skill The skill to delete
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSkill(Skill $skill): RedirectResponse
    {
        $user = Auth::user();

        $user->skills()->detach($skill);
        $skillServicesIds = $skill->services->pluck('id')->toArray();


        if (!empty($skillServicesIds)) {
            $skillServices = $user->services()->whereIn('skill_id', $skillServicesIds)->get();
            foreach ($skillServices as $service) {
                $service->requests()->delete();
                $service->user_id = null;
                $service->save();
            }
        }

        return redirect()->route('profile.show')->with('success', 'Skill deleted successfully.');
    }

    /**
     * Delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAccount(Request $request): RedirectResponse
    {
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