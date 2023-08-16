<div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg sm:p-6">
    <h3 class="mb-4 text-xl font-bold">Skills</h3>
    <ul class="flex flex-wrap gap-2 mb-8 text-gray-600">
        @foreach ($user->skills as $skill)
            <li class="relative px-3 py-2 text-sm font-semibold bg-gray-200 rounded-lg">
                {{ $skill->name }}

                <form action="{{ route('profile.skills.delete', ['skill' => $skill]) }}"
                    class="delete-button hidden absolute -top-2 -right-2" method="post">
                    @csrf
                    @method('DELETE')
                    <button
                        class="flex items-center justify-center w-5 h-5 bg-gray-400 rounded-full text-white focus:outline-none"
                        aria-label="Remove Skill">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
    <div class="flex items-center">
        <a href="{{ route('profile.skills.add') }}"
            class="mr-2 px-4 py-2 text-sm text-white font-semibold bg-blue-600 hover:bg-blue-700 rounded-lg focus:outline-none">
            Add skill
        </a>
        <button id="delete-all-button"
            class="mr-2 px-4 py-2 text-sm text-white font-semibold bg-red-600 hover:bg-red-700 rounded-lg focus:outline-none">
            Delete
        </button>
        <button id="cancelDeleteButton"
            class="hidden px-4 py-2 text-sm font-semibold bg-gray-200 hover:bg-gray-300 rounded-lg focus:outline-none delete-all-button">
            Annuler
        </button>
    </div>
</div>

<script>
    const deleteAllButton = document.getElementById('delete-all-button');
    const deleteButtons = document.querySelectorAll('.delete-button');
    const cancelDeleteButton = document.getElementById('cancelDeleteButton');

    deleteAllButton.addEventListener('click', () => {
        deleteAllButton.classList.add('hidden');
        cancelDeleteButton.classList.remove('hidden')
        deleteButtons.forEach(button => {
            button.classList.remove('hidden');
        });
    });

    cancelDeleteButton.addEventListener('click', () => {
        cancelDeleteButton.classList.add('hidden')
        deleteAllButton.classList.remove('hidden');
        deleteButtons.forEach(button => {
            button.classList.add('hidden');
        });
    })
</script>
