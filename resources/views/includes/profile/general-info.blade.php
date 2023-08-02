<div
    class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

    <h3 class="mb-4 text-xl font-bold">General information</h3>
    <form action="{{ route('profile.updateInfo') }}" method="post">
        @csrf
        @method('PATCH')
        <div class="flex flex-col space-y-6 md:max-w-md">
            <x-form-input label="Name" id="name" name="name" value="{{ $user->name }}" required=true />
            <x-form-input type="email" label="Email" id="email" value="{{ $user->email }}" name="email"
                required=true />

            
            <x-button type="submit" class="w-max text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800 cursor-pointer">
                Save
            </x-button>
        </div>
    </form>
</div>
