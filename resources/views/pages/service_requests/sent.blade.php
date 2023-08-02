@extends('layouts.default')
@section('default-content')
    <section class="px-4 pb-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-white sticky top-0">
                <tr>
                    <x-table-column title="to"
                        routeURL="{{ route('serviceRequests.sent') }}?sortColumn=receiver&sortOrder={{ $sortOrder }}" />
                    <x-table-column title="request"
                        routeURL="{{ route('serviceRequests.sent') }}?sortColumn=services.title&sortOrder={{ $sortOrder }}" />
                    <x-table-column title="date"
                        routeURL="{{ route('serviceRequests.sent') }}?sortColumn=created_at&sortOrder={{ $sortOrder }}" />
                    <x-table-column title="status"
                        routeURL="{{ route('serviceRequests.sent') }}?sortColumn=status&sortOrder={{ $sortOrder }}" />
                    <th scope="col" class="p-4 lg:p-5 ">
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($serviceRequestsSent as $serviceRequest)
                    @php
                        $requestReceiver = $serviceRequest->receiver;
                        $service = $serviceRequest->service;
                        $requestDate = \Carbon\Carbon::parse($serviceRequest->created_at)->diffForHumans();
                        
                        switch ($serviceRequest->status) {
                            case 'pending':
                                $requestStatusColor = 'bg-gray-400';
                                break;
                            case 'accepted':
                                $requestStatusColor = 'bg-green-400';
                                break;
                            case 'declined':
                                $requestStatusColor = 'bg-red-500';
                                break;
                        
                            default:
                                $requestStatusColor = 'bg-gray-400';
                                break;
                        }
                    @endphp
                    <tr class="hover:bg-gray-100 cursor-pointer"
                        onclick="location.href='{{ route('serviceRequests.show', ['serviceRequest' => $serviceRequest]) }}'">
                        <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap lg:p-5 lg:mr-0">
                            <img class="w-8 h-8 rounded"
                                src="{{ asset('storage/avatars/' . ($requestReceiver->avatar ?? 'default-avatar.png')) }}"
                                alt="{{ $requestReceiver->name }}">
                            <div class="text-sm font-normal text-gray-500">
                                <div class="text-base font-semibold text-gray-900">{{ $requestReceiver->name }}</div>
                                <div class="text-sm font-normal text-gray-500">{{ $requestReceiver->email }}</div>
                            </div>
                        </td>
                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5">{{ $service->title }}
                        </td>
                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5">{{ $requestDate }}
                        </td>
                        <td class="p-4 text-base font-normal text-gray-900 whitespace-nowrap lg:p-5">
                            <div class="w-max px-2 py-1 rounded-md text-white text-xs font-bold {{ $requestStatusColor }}">
                                {{ $serviceRequest->status }}
                            </div>
                        </td>
                        <td class="p-4 lg:p-5">
                            <form action="{{ route('serviceRequests.destroy', ['serviceRequest' => $serviceRequest]) }}"
                                method="post" class="flex justify-center items-start">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <img src="{{ asset('assets/icons/bin.svg') }}" alt="" class="h-6">
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (count($serviceRequestsSent) < 1)
            <div class="flex justify-center items-center space-x-2 mt-32">
                <img src="{{ asset('assets/icons/info.svg') }}" alt="" class="h-8 mr-2">
                No requests sent yet.
            </div>
        @endif
    </section>
@endsection
