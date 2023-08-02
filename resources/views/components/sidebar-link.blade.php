@props(['label', 'icon', 'routeName'])
@php
    $isCurrentRoute = Route::currentRouteName() == $routeName;
@endphp
<li>
    <a href="{{ route($routeName) }}"
        class="{{ $isCurrentRoute ? 'font-semibold bg-gray-200 dark:bg-gray-700' : 'bg-white dark:text-gray-200' }} flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:hover:bg-gray-700">
        <img src="{{ asset('assets/icons/' . $icon) }}" class="h-6" />
        <span class="ml-3 capitalize" sidebar-toggle-item="">{{ $label }}</span>
    </a>
</li>
