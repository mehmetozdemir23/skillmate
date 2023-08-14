@props(['service'])

<article class="md:w-96 bg-white rounded-lg shadow-md hover:shadow-lg dark:bg-gray-700 p-6">
    <header class="flex flex-col md:flex-row items-center justify-between text-xl font-semibold text-gray-800 mb-4">
        <div>{{ $service->title }}</div>
        <div class="mt-2 md:mt-0 text-sm text-gray-700 flex items-center">
            @if ($service->reviews->count() > 0)
                @php
                    $averageRating = $service->reviews->avg('rating');
                @endphp
                <span class="mr-2">
                    {{ number_format($averageRating, 1) }}
                </span>
                <img src="{{ asset('assets/icons/star.svg') }}" alt="" class="h-4">
                <a href="{{ route('reviews.show', ['service' => $service]) }}"
                    class="text-xs text-blue-500 hover:underline ml-1">
                    View All
                </a>
            @else
                <span class="text-gray-500">No reviews yet</span>
            @endif
        </div>
    </header>
    <div class="text-gray-600 leading-snug h-20 overflow-hidden mb-4">{{ $service->description }}</div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-center pt-4 border-t border-gray-300">
        <a href="{{ route('users.show', ['user' => $service->user]) }}"
            class="flex-shrink-0 flex items-center space-x-4 group mb-6 md:mb-0">
            <img src="{{ asset('storage/avatars/' . $service->user->avatar) }}" alt="{{ $service->user->name }} Avatar"
                class="w-12 h-12 rounded-full">
            <div>
                <div class="text-sm text-gray-900 group-hover:underline">
                    {{ $service->user->name }}
                </div>
                <div class="text-xs text-gray-500">
                    {{ $service->skill->name }}
                </div>
            </div>
        </a>
        <a href="{{ route('serviceRequests.create', ['service' => $service]) }}"
            class="w-full text-center md:w-max px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg md:rounded-full text-sm font-semibold">
            Ask Service
        </a>
    </div>
</article>
