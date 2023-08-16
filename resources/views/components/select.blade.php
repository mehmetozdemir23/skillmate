@props(['selectOnChange', 'name', 'label'])
<div {{ $attributes->merge(['class' => 'relative']) }}>
    <label for="{{ $name ?? $id }}" class="sr-only">{{ $label }}</label>
    <select id="{{ $name ?? $id }}"
        class="w-full block appearance-none bg-white border border-gray-300 text-gray-900 py-2.5 px-3 pr-8 rounded-lg focus:ring-fuchsia-50 focus:border-fuchsia-300 sm:text-sm"
        name="{{ $name }}" @isset($selectOnChange) onchange="{{ $selectOnChange }}" @endisset>
        {{ $options }}
    </select>
    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>
</div>
