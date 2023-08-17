@props(['name', 'id', 'label', 'value' => '', 'placeholder' => '', 'required' => false, 'readonly' => false])
<div {{ $attributes }}>
    @isset($label)
        <label for="{{ $name ?? $id }}"
            class="block mb-2 text-sm font-semibold text-gray-900 ">{{ $label }}</label>
    @endisset
    <textarea id="{{ $name ?? $id }}" name="{{ $name }}" rows="6" placeholder="{{ $placeholder }}"
        required="{{ $required }}" {{ $readonly ? 'readonly' : '' }}
        class="resize-none block p-2.5 w-full text-gray-900 border border-gray-300 sm:text-sm rounded-lg focus:ring-2 focus:ring-fuchsia-50 focus:border-fuchsia-300">{{ $value ?? old($name) }}</textarea>
</div>
