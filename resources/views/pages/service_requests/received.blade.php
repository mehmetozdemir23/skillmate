@extends('layouts.default')
@section('default-content')
    <h2 class="text-3xl font-semibold mb-6">Received Requests</h2>
    <x-table>
        <x-slot:header>
            <x-table-column title="from"
                routeURL="{{ route('serviceRequests.received') }}?sort-by-column=sender&order={{ $sortOrder ?? '' }}" />
            <x-table-column title="request"
                routeURL="{{ route('serviceRequests.received') }}?sort-by-column=services.title&order={{ $sortOrder ?? '' }}" />
            <x-table-column title="date"
                routeURL="{{ route('serviceRequests.received') }}?sort-by-column=created_at&order={{ $sortOrder ?? '' }}" />
            <x-table-column title="status"
                routeURL="{{ route('serviceRequests.received') }}?sort-by-column=status&order={{ $sortOrder ?? '' }}" />
            <th scope="col" class="p-4">
            </th>
            </x-slot>
            <x-slot:body>
                @foreach ($receivedServiceRequests as $request)
                    <x-service-request-table-row :serviceRequest="$request"
                        requestDirection="received"></x-service-request-table-row>
                @endforeach
                </x-slot>
    </x-table>
    @if (count($receivedServiceRequests) < 1)
        <div class="flex items-center justify-center h-40 text-gray-600">
            <p class="text-center">
                No requests received yet.
            </p>
        </div>
    @endif
@endsection
