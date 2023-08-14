<form action="{{ route('serviceRequests.accept', ['service' => $requestedService, 'serviceRequest' => $serviceRequest]) }}"
    method="post" class="w-full">
    @csrf
    <button type="submit"
        class="w-full font-semibold text-sm text-green-600 px-4 py-2 rounded-lg bg-green-100 hover:bg-green-200 hover:text-green-700 transition-colors duration-200 focus:ring-1 focus:ring-green-400 focus:bg-green-100 flex items-center justify-center">
        <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20.12 7.75L10.12 17.75L8.25 15.88L5.88 18.25L10.12 22.5L22.25 10.38L20.12 7.75Z"
                fill="currentColor" />
        </svg>
        Accept
    </button>
</form>
