@extends('layouts.default')
@section('default-content')
    <section class="px-4 pb-4">
        <h2 class="flex flex-col sm:flex-row sm:items-center font-semibold mb-6">
            <span class="text-3xl mb-4 sm:mb-0">
                Proposed Services
            </span>
            <a href="{{ route('services.create') }}"
                class="flex items-center flex-shrink-0 text-md w-max px-3 py-2 md:ml-auto font-semibold text-white rounded-lg bg-blue-600 hover:bg-blue-700 cursor-pointer"
                role="button">
                <svg class="mr-2 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd"></path>
                </svg>
                Add new service
            </a>
        </h2>
        @include('includes.services.settings-bar')
        @foreach ($services as $service)
            <x-service-list-item :service="$service" />
        @endforeach
    </section>
@endsection
