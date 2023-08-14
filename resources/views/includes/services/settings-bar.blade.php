<form role="navigation" class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:space-x-2 mb-4 py-4 lg:sticky top-0 bg-white"
    action="{{ route('services.index') }}" method="GET">
    <div class="relative">
        <label for="filter-by-skill" class="sr-only">Filter by Skill</label>
        <select id="filter-by-skill"
            class="block appearance-none w-full md:w-auto bg-white border border-gray-300 text-gray-900 py-2.5 px-3 pr-8 rounded-lg focus:ring-2 focus:ring-fuchsia-50 focus:border-fuchsia-300 sm:text-sm"
            onchange="this.form.submit()" name="filter-by-skill">
            <option value="all">All skills</option>
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
    <div class="relative">
        <label for="sort-by-date" class="sr-only">Sort by Date</label>
        <select id="sort-by-date"
            class="block appearance-none w-full md:w-auto bg-white border border-gray-300 text-gray-900 py-2.5 px-3 pr-8 rounded-lg focus:ring-2 focus:ring-fuchsia-50 focus:border-fuchsia-300 sm:text-sm"
            onchange="this.form.submit()" name="sort-by-date">
            <option value="newest" {{ request('sort-by-date') === 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="oldest" {{ request('sort-by-date') === 'oldest' ? 'selected' : '' }}>Oldest</option>
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>
</form>
