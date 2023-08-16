@php
    $user = Auth::user();
    $skills = $user->skills;
    $serviceSkillId = isset($service) ? $service->skill->id : null;
@endphp

<div>
    <label for="skill_id" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Skill</label>
    <select id="skill_id" name="skill_id"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option value="">Choose a skill</option>
        @foreach ($skills as $skill)
            <option value="{{ $skill->id }}" @if ($skill->id === $serviceSkillId) selected @endif>{{ $skill->name }}
            </option>
        @endforeach
    </select>
</div>
