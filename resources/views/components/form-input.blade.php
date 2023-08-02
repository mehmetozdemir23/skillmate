@props(['type' => 'text', 'name', 'id', 'label', 'value' => '', 'placeholder' => '', 'required' => false])
<div>
    <label for="{{ $id }}"
        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
        value="{{ $type == 'password' ? '' : $value ?? old($name) }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        placeholder="{{ $placeholder }}" required="{{ $required }}">

    @error($name)
        <span class="text-xs text-red-500 my-1">
            {{ $message }}
        </span>
    @enderror
</div>
