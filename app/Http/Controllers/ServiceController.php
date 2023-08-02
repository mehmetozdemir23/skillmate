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
    public function serviceBoard(Request $request): View
    {
        $request->validate([
            'search'=>'nullable|string|max:255'
        ]);

        $user = Auth::user();
        $services = Service::whereNot('user_id', $user->id);

        $search = $request->search;
        if($search){
            $services = $services->where('title','LIKE','%'.$search.'%')
            ->orWhere('description','LIKE','%'.$search.'%');
        }

        $services = $services->get();

        return view('pages.service-board', compact('services'));
    }

    public function userServices(Request $request): View
    {
        $user = Auth::user();
        $userServices = $user->services();
        $skills = $userServices->get()->pluck('skill')->unique();

        if ($request->filled('filter-by-search')) {
            $userServices->where('title', 'LIKE', '%' . $request->get('filter-by-search') . '%')
                ->orWhere('description', 'LIKE', '%' . $request->get('filter-by-search') . '%');
        }

        if ($request->filled('filter-by-skill')) {
            $userServices->where('skill_id', $request->get('filter-by-skill'));
        }

        $sortOrder = $request->input('sort-by-time', 'newest');
        $userServices->orderBy('created_at', $sortOrder === 'oldest' ? 'asc' : 'desc');

        $userServices = $userServices->paginate(3);

        return view('pages.services.userServices', compact('userServices', 'skills'));
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
            'title' => 'required|string|max:255',
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
