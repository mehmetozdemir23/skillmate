@props(['service'])

<article class="bg-white rounded-lg shadow-md hover:shadow-lg p-4 flex flex-col">
    <div class="flex-1 flex flex-col">
        <header class="text-xl font-semibold text-gray-800 mb-4">{{ $service->title }}</header>
        <p class="text-gray-600 leading-snug mb-4">{{ $service->description }}</p>
        <div class="mt-auto flex items-center space-x-4 mb-4">
            @if ($service->reviews->count() > 0)
                @php
                    $averageRating = $service->reviews->avg('rating');
                @endphp
                <div class="flex items-center space-x-1 text-sm text-gray-700">
                    <span class="font-semibold">{{ number_format($averageRating, 1) }}</span>
                    <img src="{{ asset('assets/icons/star.svg') }}" alt="Star" class="h-4">
                </div>
                <a href="{{ route('reviews.show', ['service' => $service]) }}"
                    class="text-sm text-blue-500 hover:underline">View All Reviews</a>
            @else
                <span class="text-gray-500">No reviews yet</span>
            @endif
        </div>
    </div>
    <div
        class="mt-auto flex flex-col sm:flex-row sm:items-center sm:justify-between pt-4 text-sm text-gray-700 border-t border-gray-300">
        <a href="{{ route('users.show', ['user' => $service->user]) }}" class="flex items-center mb-4 sm:mr-8 sm:mb-0">
            <img src="{{ asset('storage/avatars/' . $service->user->avatar) }}" alt="{{ $service->user->name }} Avatar"
                class="w-10 h-10 rounded-full mr-3">
            <div>
                <p class="text-gray-900 font-semibold">{{ $service->user->name }}</p>
                <p class="w-max text-xs text-gray-600">{{ $service->skill->name }}</p>
            </div>
        </a>
        <a href="{{ route('serviceRequests.create', ['service' => $service]) }}"
            class="w-full flex-shrink-0 sm:w-max text-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg sm:rounded-full text-sm font-semibold">
            Ask for Service
        </a>
    </div>
</article>
