<x-settings-bar submitRoute="{{ route('services.index') }}" id="services-form">
    <div class="relative md:w-72">
        <input type="text" name="search" id="services-search"
            class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-2 focus:ring-fuchsia-50 focus:border-fuchsia-300 block w-full p-2.5"
            placeholder="Search for services..." value="{{ request('search') }}">
    </div>

    <x-select name="filter-by-skill" label="Filter By Skill" selectOnChange="this.form.submit()">
        <x-slot:options>
            <option value="">All skills</option>
            @foreach ($skills as $skill)
                <option value="{{ $skill->id }}" @selected(request('filter-by-skill') == $skill->id)>{{ $skill->name }}</option>
            @endforeach
            </x-slot>
    </x-select>

    <x-select name="sort-by-date" label="Sort By Date" selectOnChange="this.form.submit()">
        <x-slot:options>
            <option value="newest" {{ request('sort-by-date') === 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="oldest" {{ request('sort-by-date') === 'oldest' ? 'selected' : '' }}>Oldest</option>
            </x-slot>
    </x-select>
    <script>
        let inputElement = document.getElementById('services-search');
        let inputValue = inputElement.value.trim();
        let formElement = document.getElementById('services-form');

        let searchTimer;
        inputElement.addEventListener('input', function(e) {
            clearTimeout(searchTimer);
            const inputText = e.target.value.trim();
            searchTimer = setTimeout(function() {
                if (inputText.length >= 3 || inputText.length < 1) {
                    formElement.submit();
                }
            }, 800);
        });
    </script>
</x-settings-bar>
