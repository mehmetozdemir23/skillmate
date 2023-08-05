<div
    class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
        <img id="avatarPreview" class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0"
            src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Profile picture">

        <div>
            <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
            <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                {{ $user->email }}
            </div>
            <div class="flex items-center space-x-4">
                <form action="{{ route('profile.updateAvatar') }}" method="POST" enctype="multipart/form-data"
                    id="avatarForm">
                    @csrf
                    @method('PATCH')

                    <input type="file" name="avatar" accept="image/*" class="hidden" id="avatarInput"
                        onchange="previewAvatar(event)">
                    <label for="avatarInput" id="uploadLabel"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800 cursor-pointer">
                        <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z">
                            </path>
                            <path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path>
                        </svg>
                        Upload new picture
                    </label>
                    <x-button id="submitButton" type="submit"
                        class="hidden text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800 cursor-pointer">
                        Save
                    </x-button>
                    <x-button type="button"
                        class="hidden py-2 px-4 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-700 dark:hover:bg-red-800 dark:focus:ring-red-800"
                        id="cancelButton" onclick="cancelAvatarChange()">
                        Cancel
                    </x-button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function previewAvatar(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
                document.getElementById('uploadLabel').classList.add('hidden');
                document.getElementById('submitButton').classList.remove('hidden');
                document.getElementById('cancelButton').classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function cancelAvatarChange() {
        const input = document.getElementById('avatarInput');
        input.value = '';
        document.getElementById('avatarPreview').src =
            "{{ asset('storage/avatars/' . $user->avatar) }}";
        document.getElementById('uploadLabel').classList.remove('hidden');
        document.getElementById('submitButton').classList.add('hidden');
        document.getElementById('cancelButton').classList.add('hidden');
    }
</script>
