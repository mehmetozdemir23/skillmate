<div class="flex flex-col space-y-4 md:space-y-0 md:flex-row mb-4 py-4 lg:sticky top-0 bg-white" role="navigation">
    <form class="flex items-center space-x-2 flex-shrink-0" action="{{ route('services.userServices') }}" method="GET"
        onsubmit="return submitForm()">
        @csrf
        <div class="relative">
            <label for="sort-by-time" class="sr-only">Sort by Time</label>
            <select id="sort-by-time"
                class="block appearance-none w-full md:w-auto bg-white border border-gray-300 text-gray-900 py-2.5 px-3 pr-8 rounded-lg focus:ring-2 focus:ring-fuchsia-50 focus:border-fuchsia-300 sm:text-sm"
                onchange="this.form.submit()" name="sort-by-time">
                <option value="newest" {{ request('sort-by-time') === 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="oldest" {{ request('sort-by-time') === 'oldest' ? 'selected' : '' }}>Oldest</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>
        <div class="relative">
            <label for="filter-by-skill" class="sr-only">Filter by Skill</label>
            <select id="filter-by-skill"
                class="block appearance-none w-full md:w-auto bg-white border border-gray-300 text-gray-900 py-2.5 px-3 pr-8 rounded-lg focus:ring-2 focus:ring-fuchsia-50 focus:border-fuchsia-300 sm:text-sm"
                onchange="this.form.submit()" name="filter-by-skill">
                <option value="">All skills</option>
                @foreach ($skills as $skill)
                    <option value="{{ $skill->id }}" @selected(request('filter-by-skill') == $skill->id)>{{ $skill->name }}</option>
                @endforeach
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>
        <div class="flex-shrink-0 space-x-2 md:ml-auto">
            {{ $userServices->links() }}
        </div>
    </form>
    <a href="{{ route('services.create') }}"
        class="flex flex-shrink-0 w-max ml-2 px-3 py-2 md:ml-auto font-semibold text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800 cursor-pointer"
        role="button">
        <svg class="mr-2 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true">
            <path fill-rule="evenodd"
                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                clip-rule="evenodd"></path>
        </svg>
        Add new service
    </a>
</div>
