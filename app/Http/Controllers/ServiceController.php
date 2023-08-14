<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function allServices(Request $request): View
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
            'filter-by-skill' => 'nullable|numeric|exists:skills,id',
            'sort-by-date' => 'nullable|string|in:newest,oldest'
        ]);

        $user = Auth::user();
        $services = Service::whereDoesntHave(
            'requests',
            function ($query) use ($user) {
                $query->where('sender_id', $user->id);
            }
        )->whereDoesntHave(
            'missions',
            function ($query) use ($user) {
                $query->where('receiver_id', $user->id)
                    ->whereNot('status', 'completed');
            }
        )->where('user_id', '!=', $user->id);

        $search = $request->search;
        if ($search) {
            $services = $services->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%');
        }

        $filterBySkill = $request->get('filter-by-skill');
        if ($filterBySkill) {
            $services->where('skill_id', $filterBySkill);
        }

        $sortByDateOrder = $request->get('sort-by-date', 'newest') == 'newest' ? 'asc' : 'desc';
        $services->orderBy('created_at', $sortByDateOrder);

        $services = $services->with(['user' => function ($query) {
            $query->select(['id', 'name', 'email', 'avatar']);
        }])->get();

        $skills = $services->pluck('skill')->unique();

        return view('pages.service-board', compact('services', 'skills'));
    }

    public function index(Request $request): View
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
            'filter-by-skill' => 'nullable|numeric|exists:skills,id',
            'sort-by-date' => 'nullable|string|in:newest,oldest'
        ]);

        $user = Auth::user();
        $services = $user->services();

        $filterBySkill = $request->get('filter-by-skill');
        if ($filterBySkill) {
            $services->where('skill_id', $filterBySkill);
        }

        $sortOrder = $request->input('sort-by-date', 'newest') == 'newest' ? 'asc' : 'desc';
        $services->orderBy('created_at', $sortOrder);

        $services = $services->get();
        $skills = $services->pluck('skill')->unique();

        return view('pages.services.index', compact('services', 'skills'));
    }

    public function showReviews(Service $service): View
    {
        $service->load('reviews.reviewer');
        return view('pages.services.service-reviews', compact('service'));
    }

    public function create(): View
    {
        return view('pages.services.create');
    }

    public function edit(Service $service): View
    {
        return view('pages.services.edit', compact('service'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:services,title',
            'description' => 'required|string',
            'skill_id' => 'required|exists:skills,id',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $service = new Service;
        $service->title = $request->title;
        $service->description = $request->description;
        $service->skill_id = $request->skill_id;

        $user = Auth::user();
        $user->services()->save($service);

        return redirect()->route('services.index')->with('success', 'New service created successfully.');
    }

    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'skill_id' => 'required|exists:skills,id',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
