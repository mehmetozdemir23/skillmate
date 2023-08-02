<form action="{{ route('serviceRequests.decline', ['serviceRequest' => $serviceRequest]) }}" method="post"
    class="inline-flex">
    @csrf
    @method('PUT')
    <button type="submit"
        class="inline-flex items-center text-sm text-red-600 px-4 py-1.5 rounded-full bg-white hover:bg-red-100 transition-colors duration-200 focus:ring-1 focus:ring-red-300 focus:bg-red-100">
        <img src="{{ asset('assets/icons/reject.svg') }}" class="h-6 mr-2" alt="" />
        Decline
    </button>
</form>
