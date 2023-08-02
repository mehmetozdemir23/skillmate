@extends('layouts.default')
@section('default-content')
    <section class="p-4">
        <h3 class="text-xl font-semibold my-4">
            Edit service
        </h3>
        <form action="{{ route('services.update', ['service' => $service]) }}"method="post" class="mt-8">
            @csrf
            @method('PUT')
            <div class="space-y-4 mb-8 md:space-y-8 md:max-w-md">
                @include('includes.services.skill-select')
                <x-form-input id="title" name="title" label="Title" value="{{ $service->title }}" required=true />
                <x-form-textarea id="description" name="description" label="Description" value="{{ $service->description }}"
                    required=true />
            </div>
            <x-button
                class="w-max px-3 py-2 text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800 cursor-pointer"
                type="submit">Update service</x-button>
        </form>
    </section>
@endsection
