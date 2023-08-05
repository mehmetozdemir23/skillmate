@php
    $user = Auth::user();
@endphp
<div class="relative">
    <img id="avatar-image" type="button" class="w-8 h-8 rounded-full cursor-pointer mr-2 object-cover"
        src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="User dropdown">
    <div id="user-dropdown"
        class="hidden absolute top-100 right-0 z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
            <div class="font-bold">{{ $user->name }}</div>
            <div class="font-medium truncate">{{ $user->email }}</div>
        </div>
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="avatarButton">
            <li>
                <a href="{{ route('profile.show') }}"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="post" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-2 text-left text-sm text-red-600 font-semibold hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-red-600 dark:hover:text-white">Sign
                        out</button>
                </form>
            </li>
        </ul>
    </div>
</div>
<script>
    const userDropdown = document.getElementById('user-dropdown');
    const avatarImage = document.getElementById('avatar-image');

    avatarImage.onclick = (e) => {
        e.preventDefault();
        if (userDropdown.classList.contains('hidden')) {
            userDropdown.classList.remove('hidden');
        } else {
            userDropdown.classList.add('hidden');
        }
    }

    document.addEventListener('click', function(event) {
        const outsideClick = !userDropdown.contains(event.target) && !avatarImage.contains(event.target);
        if (outsideClick) {
            userDropdown.classList.add('hidden');
        }
    });
</script>
