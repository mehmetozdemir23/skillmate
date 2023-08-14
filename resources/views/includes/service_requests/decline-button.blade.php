<form
    action="{{ route('serviceRequests.decline', ['service' => $requestedService, 'serviceRequest' => $serviceRequest]) }}"
    method="post" class="w-full">
    @csrf
    <button type="submit"
        class="w-full font-semibold text-sm text-red-600 px-4 py-2 rounded-lg bg-red-100 hover:bg-red-200 hover:text-red-700 transition-colors duration-200 focus:ring-1 focus:ring-red-300 focus:bg-red-100 flex items-center justify-center">
        <svg class="w-4 h-4 mr-1 mt-[1px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.8795 6.8795L17.1195 17.1195M6.8795 17.1195L17.1195 6.8795L6.8795 17.1195Z" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        Decline
    </button>
</form>
