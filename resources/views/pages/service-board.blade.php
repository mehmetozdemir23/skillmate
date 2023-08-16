@php
    $serviceCount = count($services);
@endphp
@extends('layouts.default')
@section('default-content')
    <h2 class="text-3xl font-semibold mb-6"><span
            class="font-bold bg-blue-200 mr-4 mt-1 px-2 py-0.5 rounded-lg">{{ $serviceCount }}</span>services offered
    </h2>
    @include('includes.services.service-board-settings-bar')
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        @foreach ($services as $service)
            <x-service-card :service="$service" />
        @endforeach
    </div>
    @if ($serviceCount < 1)
        <div class="flex items-center justify-center h-40 text-gray-600">
            <p class="text-center">
                No services found.
            </p>
        </div>
    @endif
@endsection
