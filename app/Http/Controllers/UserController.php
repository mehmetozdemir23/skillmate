<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{

    public function show(User $user)
    {
        return view('pages.users.show', compact('user'));
    }

    public function services(Request $request): View
    {
        $user = Auth::user();
        $services = $user->services();

        if ($request->filled('filter-by-search')) {
            $searchTerm = $request->get('filter-by-search');
            $services->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $filterByStatus = $request->get('filter-by-status');
        if ($filterByStatus && $filterByStatus != 'all') {
            $services->where('status', $filterByStatus);
        }

        $filterBySkill = $request->get('filter-by-skill');
        if ($filterBySkill && $filterBySkill !== 'all') {
            $services->where('skill_id', $filterBySkill);
        }

        $sortOrder = $request->input('sort-by-time', 'newest') == 'newest' ? 'asc' : 'desc';
        $services->orderBy('created_at', $sortOrder);

        $services = $services->get();
        $skills = $services->pluck('skill')->unique();

        return view('pages.users.services', compact('services', 'skills'));
    }
}
