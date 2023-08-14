<div
    class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <h3 class="mb-4 text-xl font-bold">Delete account</h3>
    <form action="{{ route('profile.account.delete') }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="px-4 py-2 text-sm text-white font-semibold bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-700 dark:hover:bg-red-800 dark:focus:ring-red-800">
            Delete
        </button>
    </form>
</div>
