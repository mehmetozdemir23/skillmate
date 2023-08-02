@extends('layouts.default')

@section('default-content')
    <div
        class="fixed top-0 left-0 right-0 bottom-0 z-50 bg-opacity-50 bg-gray-900 flex justify-center items-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-screen max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <header class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Ask for {{ $requestedService->title }}
                    </h2>
                    <a href="{{ $requestSender->id == Auth::user()->id ? route('serviceRequests.sent') : route('serviceRequests.received') }}"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </a>
                </header>
                <div class="p-6">
                    <section class="flex flex-col items-start mb-6 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-gray-800 font-semibold mb-2 text-sm sm:hidden">From:</div>
                        <div class="w-full flex items-center mb-6 sm:mb-0 sm:w-max">
                            <img class="w-16 h-16 rounded-full"
                                src="{{ asset('storage/avatars/' . $requestSender->avatar) }}"
                                alt="{{ $requestSender->name }}">
                            <div class="ml-4">
                                <div class="text-base font-semibold text-gray-900">{{ $requestSender->name }}</div>
                                <div class="text-sm font-normal text-gray-500">{{ $requestSender->email }}</div>
                            </div>
                        </div>
                        <img src="{{ asset('assets/icons/arrow-right.svg') }}" alt="" class="w-6 hidden sm:block">
                        <div class="text-gray-800 font-semibold mb-2 text-sm sm:hidden">To:</div>
                        <div class="w-full flex items-center mb-6 sm:mb-0 sm:w-max">
                            <img class="w-16 h-16 rounded-full"
                                src="{{ asset('storage/avatars/' . $requestReceiver->avatar) }}"
                                alt="{{ $requestReceiver->name }}">
                            <div class="ml-4">
                                <div class="text-base font-semibold text-gray-900">{{ $requestReceiver->name }}</div>
                                <div class="text-sm font-normal text-gray-500">{{ $requestReceiver->email }}</div>
                            </div>
                        </div>
                    </section>
                    <label for="notes" class="block text-sm font-semibold mb-2">Notes:</label>
                    <form action="{{ route('serviceRequests.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $requestedService->id }}">
                        <textarea id="notes" name="notes"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Write some notes here..."></textarea>
                        <x-button type="submit"
                            class="mt-4 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800">Send
                            request</x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
