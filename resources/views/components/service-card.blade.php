<article class="bg-gray-50 rounded-lg shadow hover:shadow-md dark:bg-gray-700 overflow-hidden p-4">
    <header class="text-sm font-bold mb-2">
        {{ $service->skill->name }}
    </header>
    <div class="mb-4">
        <h2 class="text-xl font-semibold text-gray-800 mb-1">{{ $service->title }}</h2>
        <p class="text-gray-600 leading-snug h-20 overflow-hidden">{{ $service->description }}</p>
    </div>
    <footer class="flex items-center justify-between border-t border-gray-200 pt-4">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('storage/avatars/' . $service->user->avatar) }}" alt="{{ $service->user->name }} Avatar"
                class="w-8 h-8 rounded-full">
            <span class="text-sm font-semibold text-gray-700">{{ $service->user->name }}</span>
        </div>
        <form action="{{ route('serviceRequests.create') }}" method="GET" class="m-0">
            @csrf
            <input type="hidden" name="service_id" value="{{ $service->id }}">
            <input type="hidden" name="receiver_id" value="{{ $service->user->id }}">
            <button type="submit"
                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full text-sm font-semibold">Ask
                Service</button>
        </form>
    </footer>
</article>
