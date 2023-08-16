@extends('layouts.default')
@section('default-content')
    <x-modal backRoute="{{ route('serviceBoard') }}">
        <x-slot:title>
            Request Service: {{ $requestedService->title }}
            </x-slot>
            <x-slot:content>
                <div class="flex items-center mb-6">
                    <div class="flex items-center space-x-4">
                        <img class="w-16 h-16 rounded-full" src="{{ asset('storage/avatars/' . $requestSender->avatar) }}"
                            alt="{{ $requestSender->name }}">
                        <div>
                            <div class="text-lg font-semibold text-gray-900">{{ $requestSender->name }}</div>
                            <div class="text-sm text-gray-600">Service Requester</div>
                        </div>
                    </div>
                </div>
                <hr class="border-t border-gray-200 my-4">
                <div class="flex items-center mb-6">
                    <div class="flex items-center space-x-4">
                        <img class="w-16 h-16 rounded-full" src="{{ asset('storage/avatars/' . $requestReceiver->avatar) }}"
                            alt="{{ $requestReceiver->name }}">
                        <div>
                            <div class="text-lg font-semibold text-gray-900">{{ $requestReceiver->name }}</div>
                            <div class="text-sm text-gray-600">Service Provider</div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('serviceRequests.store', ['service' => $requestedService]) }}" method="post">
                    @csrf
                    <x-form-textarea name="notes" placeholder="Your notes here..." label="Notes:"></x-form-textarea>
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg">Send
                            Request</button>
                    </div>
                </form>
                </x-slot>
    </x-modal>
@endsection
