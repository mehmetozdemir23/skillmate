<form action="{{ route('serviceRequests.undo', ['serviceRequest' => $serviceRequest]) }}" method="post"
    class="inline-flex">
    @csrf
    @method('PUT')
    <button type="submit"
        class="inline-flex items-center text-sm text-gray-600 px-4 py-1.5 rounded-full bg-white hover:bg-gray-200 transition-colors duration-200 focus:ring-1 focus:ring-gray-400 focus:bg-gray-100">
        <img src="{{ asset('assets/icons/undo.svg') }}" class="h-6 mr-2" alt="" />
        Undo
    </button>
</form>
