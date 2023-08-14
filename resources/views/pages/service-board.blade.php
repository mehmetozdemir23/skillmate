@php
    $serviceCount = count($services);
@endphp
@extends('layouts.default')
@section('default-content')
    <div class="container px-4 pb-4">
        <div class="flex items-center mb-6">
            <h1 class="text-3xl font-semibold"><span
                    class="font-bold bg-blue-200 mr-4 mt-1 px-2 py-0.5 rounded-lg">{{ $serviceCount }}</span>services offered
            </h1>
        </div>
        <div class="mb-4">
            <form id="services-form" class="space-y-2 md:flex md:space-y-0 md:space-x-2" action="{{ route('serviceBoard') }}" method="GET">
                <div class="relative md:w-72">
                    <input type="text" name="search" id="services-search"
                        class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-2 focus:ring-fuchsia-50 focus:border-fuchsia-300 block w-full p-2.5"
                        placeholder="Search for services..." value="{{ request('search') }}">
                </div>
                <div class="relative">
                    <label for="filter-by-skill" class="sr-only">Filter by Skill</label>
                    <select id="filter-by-skill"
                        class="block appearance-none w-full md:w-auto bg-white border border-gray-300 text-gray-900 py-2.5 px-3 pr-8 rounded-lg focus:ring-2 focus:ring-fuchsia-50 focus:border-fuchsia-300 sm:text-sm"
                        onchange="this.form.submit()" name="filter-by-skill">
                        <option value="">All skills</option>
                        @foreach ($skills as $skill)
                            <option value="{{ $skill->id }}" @selected(request('filter-by-skill') == $skill->id)>{{ $skill->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <div class="relative">
                    <label for="sort-by-date" class="sr-only">Sort by Time</label>
                    <select id="sort-by-date"
                        class="block appearance-none w-full md:w-auto bg-white border border-gray-300 text-gray-900 py-2.5 px-3 pr-8 rounded-lg focus:ring-2 focus:ring-fuchsia-50 focus:border-fuchsia-300 sm:text-sm"
                        onchange="this.form.submit()" name="sort-by-date">
                        <option value="newest" {{ request('sort-by-date') === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ request('sort-by-date') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </form>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($services as $service)
                <x-service-card :service="$service" />
            @empty
                <p class="text-red-500">No services found.</p>
            @endforelse
        </div>
    </div>
    <script>
        let inputElement = document.getElementById('services-search');
        let inputValue = inputElement.value.trim();
        let formElement = document.getElementById('services-form');

        let searchTimer;
        inputElement.addEventListener('input', function(e) {
            clearTimeout(searchTimer);
            const inputText = e.target.value.trim();
            searchTimer = setTimeout(function() {
                if (inputText.length >= 3 || inputText.length < 1) {
                    formElement.submit();
                }
            }, 800);
        });
    </script>
@endsection
