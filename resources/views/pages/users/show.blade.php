@extends('layouts.default')

@section('default-content')
    <div class="flex items-center mb-12">
        <img class="w-16 h-16 rounded-full" src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="{{ $user->name }}">
        <div class="ml-4">
            <h2 class="text-2xl font-semibold text-gray-800">{{ $user->name }}</h2>
            <p class="text-gray-600">{{ $user->email }}</p>
        </div>
    </div>
    <div class="mb-10">
        <h3 class="text-xl font-semibold mb-4">Skills</h3>
        <ul class="flex flex-wrap gap-2 text-gray-700">
            @foreach ($user->skills as $skill)
                <li class="w-max px-3 py-2 text-sm font-semibold bg-gray-200 rounded-lg">
                    {{ $skill->name }}
                </li>
            @endforeach
        </ul>
    </div>
    <div class="mb-10">
        <h3 class="text-xl font-semibold mb-4">Ratings</h3>
        @if (count($services) > 0)
            <ul class="space-y-4">
                @foreach ($services as $service)
                    <li class="bg-gray-100 rounded-lg p-4">
                        <div class="flex flex-col justify-between">
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">{{ $service->title }}</h4>
                            @if ($service->reviews()->count() > 0)
                                @php
                                    $averageRating = $service->reviews->avg('rating');
                                @endphp
                                <div class="flex items-center space-x-2 text-gray-700">
                                    <span class="text-lg font-semibold">{{ number_format($averageRating, 1) }}</span>
                                    <img src="{{ asset('assets/icons/star.svg') }}" alt="Star" class="h-5">
                                </div>
                            @else
                                <span class="text-gray-500 mt-2">No reviews yet</span>
                            @endif
                        </div>
                        <p class="text-gray-700 mt-2">{{ $service->description }}</p>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No reviews yet.</p>
        @endif
    </div>
@endsection
