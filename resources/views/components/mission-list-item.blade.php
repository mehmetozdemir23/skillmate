@props(['mission'])

<article
    class="mb-4 flex flex-col md:flex-row bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm 2xl:col-span-2 dark:border-gray-700 dark:bg-gray-800">
    <aside class="h-36 md:h-auto bg-sky-100 w-auto md:w-48 flex flex-col justify-center items-center p-4">
        <img src="{{ asset('storage/avatars/' . $mission->receiver->avatar) }}" alt="{{ $mission->receiver->name }}"
            class="w-16 h-16 rounded-full object-contain mb-2">
        <span class="font-semibold">{{ $mission->receiver->name }}</span>
    </aside>
    <main class="p-4 flex-1">
        <h1 class="text-xl font-bold text-gray-800 mb-3">{{ $mission->service->title }}</h1>
        <div class="flex items-center mb-8 space-x-2">
            <span
                class="bg-gray-200 text-gray-800 py-1.5 px-3 rounded-full text-xs">{{ $mission->service->skill->name }}</span>
        </div>
        <div class="flex items-center space-x-2">
            @php
                $user = Auth::user();
                $missionStatus = $mission->status;
                $statusColorClasses = [
                    'pending' => 'bg-gray-200 text-gray-700',
                    'in_progress' => 'bg-indigo-200 text-indigo-800',
                    'completed' => 'bg-green-200 text-green-800',
                    'default' => 'bg-gray-200 text-gray-600',
                ];
                $statusColor = $statusColorClasses[$missionStatus] ?? $statusColorClasses['default'];
            @endphp
            @if ($mission->receiver->id == $user->id || $missionStatus == 'completed')
                <span class="text-xs font-semibold mr-2 px-2.5 py-1 rounded {{ $statusColor }}">
                    {{ Str::headline($missionStatus) }}
                </span>
            @endif
            @if ($mission->review)
                <div class="flex space-x-1 items-center">
                    <span>{{ number_format($mission->review->rating, 1) }}</span>
                    <img src="{{ asset('assets/icons/star.svg') }}" alt="" class="h-4 mt-[2px]">
                </div>
            @endif
            @if ($mission->receiver->id == $user->id)
                @if ($missionStatus == 'completed' && !$mission->review)
                    <a href="{{ route('reviews.create', ['mission' => $mission]) }}"
                        class="text-xs font-semibold inline-block px-2 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Rate the mission
                    </a>
                @elseif($missionStatus == 'completed' && !$mission->review)
                    <span class="px-2 py-1 text-xs font-semibold bg-gray-300">
                        Not rated
                    </span>
                @endif
            @else
                @if ($missionStatus == 'pending')
                    <form action="{{ route('missions.start', ['mission' => $mission]) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center font-semibold text-sm text-white px-3 py-2 rounded-lg bg-green-500 hover:bg-green-600 focus:bg-green-600">
                            <img src="{{ asset('assets/icons/rocket.svg') }}" alt="" class="h-6 mr-2">
                            Start
                        </button>
                    </form>
                @elseif ($missionStatus == 'in_progress')
                    <form action="{{ route('missions.end', ['mission' => $mission]) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center font-semibold text-sm text-white px-3 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-600 focus:bg-indigo-600">
                            <img src="{{ asset('assets/icons/accept.svg') }}" alt="" class="h-6 mr-2">
                            End
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </main>
</article>
