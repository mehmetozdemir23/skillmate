@props(['service'])
<article
    class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <h1 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $service->title }}</h1>
    <p class="mt-2 text-base text-gray-700 dark:text-gray-400">{{ $service->description }}</p>
    <div class="mt-4 flex flex-col md:flex-row md:justify-between md:items-center">
        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
            {{ $service->skill->name }}
        </span>
        <form action="{{ route('services.destroy', ['service' => $service]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="inline-flex items-center px-5 py-2 text-sm text-red-600 border border-red-300 rounded-md bg-white hover:border-red-400 hover:bg-red-50 transition-colors duration-200 focus:ring-1 focus:ring-red-300 focus:bg-red-50">
                <img src="{{ asset('assets/icons/bin.svg') }}" class="h-4 mr-1" alt="Delete Icon" />
                Delete
            </button>
        </form>
    </div>
</article>
