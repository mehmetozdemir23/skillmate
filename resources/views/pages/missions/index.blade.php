@extends('layouts.default')
@section('default-content')
    <h2 class="text-3xl font-semibold mb-6">Missions</h2>
    @include('includes.missions.missions-settings-bar')
    @forelse ($missions as $mission)
        <x-mission-list-item :mission="$mission" />
    @empty
        <div class="flex items-center justify-center h-40 text-gray-600">
            <p class="text-center">
               No missions found.
            </p>
        </div>
    @endforelse
@endsection
