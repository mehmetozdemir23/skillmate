@extends('layouts.default')
@section('default-content')
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg p-8 w-screen mx-2 md:mx-0 md:w-1/3">
            <h2 class="text-lg font-semibold mb-4">Write a Review</h2>
            <form action="{{ route('reviews.store', ['mission' => $mission]) }}" method="post">
                @csrf
                <textarea name="comment" class="w-full h-24 p-2 border rounded mb-4" placeholder="Write your review..."></textarea>

                <!-- Rating Select -->
                <div class="mb-4">
                    <label for="rating" class="block text-gray-700 mb-2">Rate the mission:</label>
                    <select name="rating" id="rating"
                        class="block w-full py-2 pl-2 border rounded-lg focus:outline-none appearance-none">
                        <option value="5">⭐⭐⭐⭐⭐</option>
                        <option value="4">⭐⭐⭐⭐</option>
                        <option value="3">⭐⭐⭐</option>
                        <option value="2">⭐⭐</option>
                        <option value="1">⭐</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button
                        class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition-colors duration-300">
                        Submit
                    </button>
                    <a href="{{ URL::previous() }}"
                        class="bg-gray-200 text-gray-700 py-2 px-4 rounded hover:bg-gray-300 ml-2 transition-colors duration-300">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
