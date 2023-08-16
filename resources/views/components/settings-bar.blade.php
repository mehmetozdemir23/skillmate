@props(['submitRoute', 'formMethod'])
<form role="navigation" {{ $attributes }}
    class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:space-x-2 mb-4 py-4 lg:sticky top-0 bg-white"
    action="{{ $submitRoute }}" method="{{ $formMethod ?? 'get' }}">
    {{ $slot }}
</form>
