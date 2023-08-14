@extends('layouts.default')
@section('default-content')
    <div
        class="fixed top-0 left-0 right-0 bottom-0 z-50 bg-opacity-50 bg-gray-900 flex justify-center items-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-screen max-h-full">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md">

            <div class="pl-6 pr-4 py-4 border-b flex items-start justify-between">
                <h2 class="mr-2 text-2xl font-bold text-gray-900">
                    Request Service: {{ $requestedService->title }}
                </h2>
                <a href="{{ route('serviceBoard') }}"
                    class="flex-shrink-0 text-gray-500 bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </a>
            </div>
            <div class="p-6">
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
                <form action="{{ route('serviceRequests.store',['service'=>$requestedService]) }}" method="post">
                    @csrf
                    <label for="notes" class="block text-sm font-semibold mb-2">Add Notes:</label>
                    <textarea id="notes" name="notes"
                        class="block w-full p-3 text-sm text-gray-900 bg-gray-100 rounded-lg border border-gray-300 focus:ring focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 resize-none"
                        placeholder="Your notes here..."></textarea>
                    <div class="mt-6">
                        <x-button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-full">Send
                            Request</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
