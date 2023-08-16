@extends('layouts.default')
@section('default-content')
    <h2 class="text-3xl font-semibold mb-6">Sent Requests</h2>
    <x-table>
        <x-slot:header>
            <x-table-column title="to"
                routeURL="{{ route('serviceRequests.sent') }}?sort-by-column=receiver&order={{ $sortOrder }}" />
            <x-table-column title="request"
                routeURL="{{ route('serviceRequests.sent') }}?sort-by-column=services.title&order={{ $sortOrder }}" />
            <x-table-column title="date"
                routeURL="{{ route('serviceRequests.sent') }}?sort-by-column=created_at&order={{ $sortOrder }}" />
            <x-table-column title="status"
                routeURL="{{ route('serviceRequests.sent') }}?sort-by-column=status&order={{ $sortOrder }}" />
            <th scope="col" class="p-4 lg:p-5 ">
            </th>
            </x-slot>
            <x-slot:body>
                @foreach ($sentServiceRequests as $request)
                    <x-service-request-table-row :serviceRequest="$request" requestDirection="sent"></x-service-request-table-row>
                @endforeach
                </x-slot>
    </x-table>
    @if (count($sentServiceRequests) < 1)
        <div class="flex items-center justify-center h-40 text-gray-600">
            <p class="text-center">
                No requests sent yet.
            </p>
        </div>
    @endif
@endsection
