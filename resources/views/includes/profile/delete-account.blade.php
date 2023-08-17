<div
    class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2  sm:p-6 ">
    <h3 class="mb-4 text-xl font-bold">Delete account</h3>
    <form action="{{ route('profile.account.delete') }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="px-4 py-2 text-sm text-white font-semibold bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300   ">
            Delete
        </button>
    </form>
</div>
