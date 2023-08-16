@extends('layouts.default')

@section('default-content')
    @php
        $user = Auth::user();
        $requestSender = $serviceRequest->sender;
        $requestReceiver = $serviceRequest->receiver;
        $requestedService = $serviceRequest->service;
        $backRouteSuffix = $requestSender->id == $user->id ? 'sent' : 'received';
    @endphp
    <x-modal backRoute="{{ route('serviceRequests.' . $backRouteSuffix) }}">
        <x-slot:title>
            Request Service: {{ $requestedService->title }}
            </x-slot>
            <x-slot:content>
                <div class="flex flex-col items-start space-y-4 mb-6">
                    <a href="{{ route('users.show', ['user' => $requestSender]) }}" class="flex items-center space-x-3">
                        <img class="w-12 h-12 sm:w-16 sm:h-16 rounded-full"
                            src="{{ asset('storage/avatars/' . $requestSender->avatar) }}" alt="{{ $requestSender->name }}">
                        <div class="flex flex-col">
                            <div class="sm:text-lg font-semibold text-gray-900">{{ $requestSender->name }}</div>
                            <div class="text-xs sm:text-sm text-gray-600">Service Requester</div>
                        </div>
                    </a>
                    <div class="w-full pl-6 sm:pl-8 my-4">
                        <div class="w-full h-4 border-l-2 border-gray-300"></div>
                        <div class="w-full border-l-2 border-gray-300 pl-4 flex flex-col items-center">
                            <div class="w-full bg-blue-100 p-4 rounded-lg">
                                <p class="max-h-48 overflow-y-scroll text-clip text-gray-800">{{ $serviceRequest->notes }}
                                </p>
                            </div>
                        </div>
                        <div class="h-4 border-l-2 border-gray-300"></div>
                    </div>
                    <a href="{{ route('users.show', ['user' => $requestReceiver]) }}" class="flex items-center space-x-3">
                        <img class="w-12 h-12 sm:w-16 sm:h-16 rounded-full"
                            src="{{ asset('storage/avatars/' . $requestReceiver->avatar) }}" alt="{{ $requestReceiver->name }}">
                        <div class="flex flex-col">
                            <div class="sm:text-lg font-semibold text-gray-900">{{ $requestReceiver->name }}</div>
                            <div class="text-xs sm:text-sm text-gray-600">Service Provider</div>
                        </div>
                    </a>
                </div>
                @if ($requestReceiver->id == $user->id && $serviceRequest->status != 'completed')
                    <div class="flex space-x-2 mt-4">
                        @if ($serviceRequest->status == 'accepted')
                            @include('includes.service_requests.undo-button')
                            @include('includes.service_requests.decline-button')
                        @elseif ($serviceRequest->status == 'declined')
                            @include('includes.service_requests.accept-button')
                            @include('includes.service_requests.undo-button')
                        @else
                            @include('includes.service_requests.accept-button')
                            @include('includes.service_requests.decline-button')
                        @endif
                    </div>
                @endif
                </x-slot>
    </x-modal>
@endsection
