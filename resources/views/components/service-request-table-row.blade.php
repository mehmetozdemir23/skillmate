@props(['serviceRequest', 'requestDirection'])

@php
    $requestUser = $requestDirection == 'sent' ? $serviceRequest->receiver : $serviceRequest->sender;
    $service = $serviceRequest->service;
    $requestDate = \Carbon\Carbon::parse($serviceRequest->created_at)->diffForHumans();
    
    $statusColorClasses = [
        'pending' => 'bg-gray-200 text-gray-700',
        'accepted' => 'bg-green-200 text-green-800',
        'declined' => 'bg-red-500 text-white',
    ];
    
    $requestStatusColor = $statusColorClasses[$serviceRequest->status] ?? 'bg-gray-200 text-gray-700';
@endphp

<tr class="hover:bg-gray-100 cursor-pointer"
    onclick="location.href='{{ route('serviceRequests.show', ['service' => $service, 'serviceRequest' => $serviceRequest]) }}'">
    <td class="flex items-center p-4 mr-12 space-x-4 whitespace-nowrap lg:p-5 lg:mr-0">
        <img class="w-8 h-8 rounded-full"
            src="{{ asset('storage/avatars/' . ($requestUser->avatar ?? 'default-avatar.png')) }}"
            alt="{{ $requestUser->name }}">
        <div class="text-sm font-normal text-gray-500">
            <div class="text-base font-semibold text-gray-900">{{ $requestUser->name }}</div>
            <div class="text-sm font-normal text-gray-500">{{ $requestUser->email }}</div>
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
            {{ $serviceRequest->status }}
        </div>
    </td>
    <td class="p-4 flex-shrink-0">
        <form
            action="{{ route('serviceRequests.destroy', ['service' => $service, 'serviceRequest' => $serviceRequest]) }}"
            method="post" class="flex justify-center items-start">
            @csrf
            @method('DELETE')
            <button type="submit" class="flex-shrink-0">
                <img src="{{ asset('assets/icons/bin.svg') }}" alt="" class="h-6">
            </button>
        </form>
    </td>
</tr>
