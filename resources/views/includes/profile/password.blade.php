<div id="password"
    class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2  sm:p-6 ">
    <h3 class="mb-4 text-xl font-bold">Password information</h3>
    <form action="{{route('profile.password.update')}}" method="post">
        @csrf
        @method('PATCH')
        <div class="flex flex-col space-y-6 md:max-w-md">
            <x-form-input type="password" label="Current password" id="current_password" name="current_password" required=true />
            <x-form-input type="password" label="New password" id="new_password" name="new_password" required=true />
            <x-form-input type="password" label="Confirm password" id="password_confirmation" name="new_password_confirmation" required=true />
            <x-button type="submit" class="w-max text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300    cursor-pointer">
                Change password
            </x-button>
        </div>
    </form>
</div>
