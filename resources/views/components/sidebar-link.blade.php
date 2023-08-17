@props(['label', 'icon', 'routeName'])
@php
    $isCurrentRoute = Route::currentRouteName() == $routeName;
@endphp
<li>
    <a href="{{ route($routeName) }}"
        class="{{ $isCurrentRoute ? 'font-semibold bg-gray-200 ' : 'bg-white ' }} flex items-center p-2 lg:pl-4 text-base text-gray-900 rounded-lg hover:bg-gray-200 group ">
        <img src="{{ asset('assets/icons/' . $icon) }}" class="h-6" />
        <span class="hidden lg:block ml-3 capitalize" sidebar-toggle-item="">{{ $label }}</span>
    </a>
</li>
