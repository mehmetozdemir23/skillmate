@extends('layouts.default')
@section('default-content')
    <x-modal backRoute="{{ route('profile.show') }}">
        <x-slot:title>
            New Skill
        </x-slot>
        <x-slot:content>
            <form action="{{ route('profile.skills.store') }}" method="post">
                @csrf
                <x-select name="skill_id" label="Choose a skill" class="mb-8">
                    <x-slot:options>
                        <option value="">Choose a skill</option>
                        @foreach ($skills as $skill)
                            <option value="{{ $skill->id }}">
                                {{ $skill->name }}
                            </option>
                        @endforeach
                    </x-slot>
                </x-select>
                <div class="flex justify-end">
                    <button
                        class="ml-auto flex w-max px-3 py-2 font-semibold text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 cursor-pointer"
                        type="submit">Add skill
                    </button>
                    <a href="{{ URL::previous() }}"
                        class="bg-gray-200 text-gray-700 py-2 px-4 rounded hover:bg-gray-300 ml-2 transition-colors duration-300">
                        Cancel
                    </a>
                </div>
            </form>
        </x-slot>
    </x-modal>
@endsection
