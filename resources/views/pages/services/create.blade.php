@extends('layouts.default')
@section('default-content')
    <div class="p-4">
        <h3 class="text-xl font-semibold mb-4">
            New service
        </h3>
        <form action="{{ route('services.store') }}"method="post" class="mt-8">
            @csrf
            <div class="space-y-4 mb-8 md:space-y-8 md:max-w-md">
                @include('includes.services.skill-select')
                <x-form-input id="title" name="title" label="Title" required=true />
                <x-form-textarea id="description" name="description" label="Description" required=true />
            </div>
            <button
                class="flex w-max px-3 py-2 font-semibold text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800 cursor-pointer"
                type="submit">Add service</button>
        </form>
    </div>
@endsection
