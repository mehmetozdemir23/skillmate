<x-settings-bar submitRoute="{{ route('missions.index') }}">
    <x-select name="filter-by-type" label="Filter By Type" selectOnChange="this.form.submit()">
        <x-slot:options>
            <option value="proposed" @selected(request('filter-by-type') == 'proposed')>Proposed
            </option>
            <option value="received" @selected(request('filter-by-type') == 'received')>Received
            </option>
            </x-slot>
    </x-select>
    <x-select name="filter-by-status" label="Filter By Status" selectOnChange="this.form.submit()">
        <x-slot:options>
            <option value="">All status</option>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(request('filter-by-status') == $status)>{{ Str::headline($status) }}
                </option>
            @endforeach
            </x-slot>
    </x-select>
    <x-select name="sort-by-date" label="Sort By Date" selectOnChange="this.form.submit()">
        <x-slot:options>
            <option value="newest" {{ request('sort-by-date') === 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="oldest" {{ request('sort-by-date') === 'oldest' ? 'selected' : '' }}>Oldest</option>
            </x-slot>
    </x-select>
</x-settings-bar>
