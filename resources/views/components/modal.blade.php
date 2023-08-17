<div
    class="fixed top-0 left-0 right-0 bottom-0 z-50 bg-opacity-50 bg-gray-900 flex justify-center items-center w-full p-4 overflow-x-hidden overflow-y-auto h-screen">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="pl-6 pr-4 py-4 border-b flex items-start justify-between">
            <h2 class="mr-2 text-xl sm:text-2xl font-bold text-gray-900">
                {{ $title }}
            </h2>
            <a href="{{ $backRoute }}"
                class="flex-shrink-0 text-gray-500 bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center  ">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </a>
        </div>
        <div class="p-4 sm:p-6">
            {{ $content }}
        </div>
    </div>
</div>
