<form action="{{ route('serviceRequests.accept', ['serviceRequest' => $serviceRequest]) }}" method="post"
    class="inline-flex">
    @csrf
    @method('PUT')
    <button type="submit"
        class="inline-flex items-center text-sm text-green-600 px-4 py-1.5 rounded-full bg-white hover:bg-green-100 transition-colors duration-200 focus:ring-1 focus:ring-green-400 focus:bg-green-100">
        <img src="{{ asset('assets/icons/accept.svg') }}" class="h-6 mr-2" alt="" />
        Accept
    </button>
</form>
