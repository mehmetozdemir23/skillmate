@extends('layouts.default')
@section('default-content')
    <x-modal backRoute="{{route('missions.index')}}">
        <x-slot:title>
            Write a Review
        </x-slot>
        <x-slot:content>
            <form action="{{ route('reviews.store', ['mission' => $mission]) }}" method="post">
                @csrf
                <x-select name="rating" label="Rate the mission:" class="mb-4">
                    <x-slot:options>
                        <option value="5">⭐⭐⭐⭐⭐</option>
                        <option value="4">⭐⭐⭐⭐</option>
                        <option value="3">⭐⭐⭐</option>
                        <option value="2">⭐⭐</option>
                        <option value="1">⭐</option>
                    </x-slot>
                </x-select>
                <x-form-textarea name="comment" class="mb-8"></x-form-textarea>
                <div class="flex justify-end">
                    <button
                        class="ml-auto flex w-max px-3 py-2 font-semibold text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 cursor-pointer"
                        type="submit">Submit
                    </button>
                    <a href="{{ URL::previous() }}"
                        class="bg-gray-200 text-gray-700 py-2 px-4 rounded hover:bg-gray-300 ml-2 transition-colors duration-300">
                        Cancel
                    </a>
                </div>
            </form>
        </x-slot>
    </x-modal>
@endsection
