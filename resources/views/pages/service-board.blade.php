@php
    $serviceCount = count($services);
@endphp

@extends('layouts.default')
@section('default-content')
    <div class="container p-4">
        <div class="flex items-center mb-6">
            <h1 class="text-3xl font-bold">All services offered</h1>
            <div class="h-max font-bold bg-blue-200 ml-4 mt-1 px-2 py-0.5 rounded-lg">{{ $serviceCount }}</div>
        </div>

        <!-- Search Form -->
        <div class="mb-4">
            <form id="services-form" class="space-y-2 md:flex md:space-y-0" action="{{ route('serviceBoard') }}" method="GET"
                onsubmit="return submitForm()">
                @csrf
                <div class="relative md:w-72 md:mr-2">
                    <input type="text" name="search" id="services-search" oninput="handleInput()"
                        class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-2 focus:ring-fuchsia-50 focus:border-fuchsia-300 block w-full p-2.5"
                        placeholder="Search for services..." value="{{ request('search') }}">
                </div>
            </form>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if ($serviceCount > 0)
                @foreach ($services as $service)
                    <x-service-card :service="$service" />
                @endforeach
            @else
                <p class="text-red-500">No services found.</p>
            @endif
        </div>
    </div>
@endsection
