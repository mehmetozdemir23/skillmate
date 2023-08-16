@extends('layouts.default')

@section('default-content')
<div class="px-4 pb-4">
    <h2 class="text-3xl font-semibold mb-6">Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-6">
        <div class="bg-blue-100 rounded-lg p-6 border border-blue-300 shadow-sm">
            <h3 class="text-xl font-semibold mb-2 text-blue-800">My Services</h3>
            <p class="text-gray-600 text-sm">{{ $proposedServicesCount }} Proposed</p>
            <a href="{{ route('services.create') }}" class="text-blue-500 hover:underline mt-4 inline-block">Create New Service</a>
        </div>

        <div class="bg-green-100 rounded-lg p-6 border border-green-300 shadow-sm">
            <h3 class="text-xl font-semibold mb-2 text-green-800">Pending Requests</h3>
            <p class="text-gray-600 text-sm">{{ $pendingServiceRequestsCount }} Pending</p>
            <a href="{{ route('serviceRequests.received') }}" class="text-green-700 hover:underline mt-4 inline-block">View Requests</a>
        </div>

        <div class="bg-yellow-100 rounded-lg p-6 border border-yellow-300 shadow-sm">
            <h3 class="text-xl font-semibold mb-2 text-yellow-800">Ongoing Missions</h3>
            <p class="text-gray-600 text-sm">{{ $onGoingMissionsCount }} Ongoing</p>
            <a href="{{ route('missions.index') }}?filter-by-status=in_progress" class="text-yellow-700 hover:underline mt-4 inline-block">View Missions</a>
        </div>

        <div class="bg-purple-100 rounded-lg p-6 border border-purple-300 shadow-sm">
            <h3 class="text-xl font-semibold mb-2 text-purple-800">Mission History</h3>
            <p class="text-gray-600 text-sm">{{ $completedMissionsCount }} Completed</p>
            <a href="{{ route('missions.index') }}?filter-by-status=completed" class="text-purple-700 hover:underline mt-4 inline-block">View History</a>
        </div>
    </div>
</div>
@endsection
