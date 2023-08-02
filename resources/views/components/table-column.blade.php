@props(['title', 'routeURL'])
<th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase lg:p-5">
    <div class="w-full flex items-center justify-between">
        {{ $title }}
        <a href="{{ $routeURL }}">
            <img src="{{ asset('assets/icons/sort.svg') }}" alt="" class="ml-2 h-6">
        </a>
    </div>
</th>
