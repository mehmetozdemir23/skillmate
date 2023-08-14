@extends('layouts.default')
@section('default-content')
    <section class="px-4 pb-4">
        <h2 class="text-3xl font-semibold mb-6">Missions</h2>
        @include('includes.missions.settings-bar')
        @foreach ($missions as $mission)
            <x-mission-list-item :mission="$mission" />
        @endforeach
    </section>
@endsection
