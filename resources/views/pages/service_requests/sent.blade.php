@extends('layouts.default')
@section('default-content')
    <section class="px-4 pb-4">
        <h2 class="text-3xl font-semibold mb-6">Sent Requests</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white sticky top-0">
                    <tr>
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
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($sentServiceRequests as $request)
                        @php
                            $requestReceiver = $request->receiver;
                            $service = $request->service;
                            $requestDate = \Carbon\Carbon::parse($request->created_at)->diffForHumans();
                            
                            switch ($request->status) {
                                case 'pending':
                                    $requestStatusColor = 'bg-gray-300 text-gray-700';
                                    break;
                                case 'accepted':
                                    $requestStatusColor = 'bg-green-200 text-green-800';
                                    break;
                                case 'declined':
                                    $requestStatusColor = 'bg-red-500 text-white';
                                    break;
                            
                                default:
                                    $requestStatusColor = 'bg-gray-200 text-gray-700';
                                    break;
                            }
                        @endphp
                        <tr class="hover:bg-gray-100 cursor-pointer"
                            onclick="location.href='{{ route('serviceRequests.show', ['service' => $service, 'serviceRequest' => $request]) }}'">
                            <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap lg:p-5 lg:mr-0">
                                <img class="w-8 h-8 rounded"
                                    src="{{ asset('storage/avatars/' . ($requestReceiver->avatar ?? 'default-avatar.png')) }}"
                                    alt="{{ $requestReceiver->name }}">
                                <div class="text-sm font-normal text-gray-500">
                                    <div class="text-base font-semibold text-gray-900">{{ $requestReceiver->name }}</div>
                                    <div class="text-sm font-normal text-gray-500">{{ $requestReceiver->email }}</div>
                                </div>
                            </td>
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5">
                                {{ $service->title }}
                            </td>
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5">
                                {{ $requestDate }}
                            </td>
                            <td class="p-4 text-base font-normal whitespace-nowrap lg:p-5">
                                <div class="w-max px-2 py-1 rounded-md text-xs font-bold {{ $requestStatusColor }}">
                                    {{ $request->status }}
                                </div>
                            </td>
                            <td class="p-4 lg:p-5">
                                <form
                                    action="{{ route('serviceRequests.destroy', ['service' => $service, 'serviceRequest' => $request]) }}"
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
        </div>
        @if (count($sentServiceRequests) < 1)
            <div class="flex justify-center items-center space-x-2 mt-32">
                <img src="{{ asset('assets/icons/info.svg') }}" alt="" class="h-8 mr-2">
                No requests sent yet.
            </div>
        @endif
    </section>
@endsection
