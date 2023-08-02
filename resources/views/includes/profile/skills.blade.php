<div
    class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <h3 class="mb-4 text-xl font-bold">Skills</h3>
    <ul class="flex flex-wrap gap-4">
        @foreach ($user->skills as $skill)
            <li class="px-3 py-2 text-sm font-semibold bg-gray-200 rounded-lg">
                {{ $skill->name }}
            </li>
        @endforeach
    </ul>
</div>
