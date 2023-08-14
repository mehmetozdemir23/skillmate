@extends('layouts.default')

@section('default-content')
    <div class="container px-4 pb-4">
        <h2 class="text-2xl font-semibold mb-4">Reviews for {{ $service->title }}</h2>

        @if ($service->reviews->count() > 0)
            <ul class="space-y-4">
                @foreach ($service->reviews as $review)
                    <li class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:items-start md:space-x-4">
                            <div class="flex items-center">
                                <span class="text-xl font-semibold">{{ number_format($review->rating, 1) }}</span>
                                <img src="{{ asset('assets/icons/star.svg') }}" alt="Star" class="h-5 ml-2">
                            </div>
                            <div class="flex flex-col md:pl-4">
                                <p class="text-gray-700 text-left">{{ $review->comment }}</p>
                                <div class="mt-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full overflow-hidden">
                                            <img src="{{ asset('storage/avatars/' . $review->reviewer->avatar) }}"
                                                alt="{{ $review->reviewer->name }} Avatar"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $review->reviewer->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $review->reviewer->email }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-4 text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No reviews for this service yet.</p>
        @endif
    </div>
@endsection
