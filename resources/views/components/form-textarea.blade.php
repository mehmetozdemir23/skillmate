@props(['name', 'id', 'label', 'value' => '', 'placeholder' => '', 'required' => false])
<div>
    <label for="{{ $id }}"
        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">{{ $label }}</label>
    <textarea id="{{ $id }}" name="{{ $name }}" rows="6" required="{{ $required }}"
        class="block p-2.5 w-full text-gray-900 border border-gray-300 sm:text-sm rounded-lg focus:ring-2 focus:ring-fuchsia-50 focus:border-fuchsia-300">{{ $value ?? old($name) }}</textarea>
</div>
