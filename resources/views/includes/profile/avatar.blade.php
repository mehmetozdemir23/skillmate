<div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 sm:p-6">
    <div class="flex flex-col sm:flex-row sm:space-x-4">
        <img id="avatarPreview" class="w-28 h-28 mb-4 sm:mb-0 object-cover rounded-lg"
            src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Profile picture">

        <div>
            <h3 class="mb-1 text-xl font-bold text-gray-900">{{ $user->name }}</h3>
            <div class="mb-4 text-sm text-gray-500">
                {{ $user->email }}
            </div>

            <div class="flex flex-col space-y-2 sm:flex-row sm:items-center sm:space-x-2 sm:space-y-0">
                <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data"
                    id="avatarForm">
                    @csrf
                    @method('PATCH')

                    <input type="file" name="avatar" accept="image/*" class="hidden" id="avatarInput"
                        onchange="previewAvatar(event)">

                    <label for="avatarInput" id="uploadLabel"
                        class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-white rounded-lg bg-blue-600 hover:bg-blue-700 cursor-pointer">
                        <img src="{{asset('assets/icons/upload.svg')}}" alt="upload" class="h-6 mr-2">
                        Upload new picture
                    </label>

                    <button id="submitButton" type="submit"
                        class="hidden py-2 px-4 text-sm text-white font-semibold bg-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer">
                        Save
                    </button>

                    <button type="button"
                        class="hidden py-2 px-4 text-sm text-white font-semibold bg-red-600 rounded-lg hover:bg-red-700 cursor-pointer"
                        id="cancelButton" onclick="cancelAvatarChange()">
                        Cancel
                    </button>
                </form>

                @if ($user->avatar != 'default-avatar.svg')
                    <form action="{{ route('profile.avatar.delete') }}" id="deleteForm" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 text-sm text-white font-semibold bg-red-600 rounded-lg hover:bg-red-700 cursor-pointer">
                            Delete
                        </button>
                    </form>
                @endif
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
                const avatarPreview = document.getElementById('avatarPreview');
                const uploadLabel = document.getElementById('uploadLabel');
                const deleteForm = document.getElementById('deleteForm');
                const submitButton = document.getElementById('submitButton');
                const cancelButton = document.getElementById('cancelButton');

                avatarPreview.src = e.target.result;
                uploadLabel.classList.add('hidden');
                deleteForm?.classList.add('hidden');
                submitButton.classList.remove('hidden');
                cancelButton.classList.remove('hidden');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function cancelAvatarChange() {
        const input = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');
        const uploadLabel = document.getElementById('uploadLabel');
        const deleteForm = document.getElementById('deleteForm');
        const submitButton = document.getElementById('submitButton');
        const cancelButton = document.getElementById('cancelButton');

        input.value = '';
        avatarPreview.src = "{{ asset('storage/avatars/' . $user->avatar) }}";
        uploadLabel.classList.remove('hidden');
        deleteForm?.classList.remove('hidden');
        submitButton.classList.add('hidden');
        cancelButton.classList.add('hidden');
    }
</script>
