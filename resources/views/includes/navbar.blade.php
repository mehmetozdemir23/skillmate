<nav class="fixed z-30 w-full bg-white border-b border-gray-200  ">
    <div class="px-3 py-6 lg:px-5 lg:pl-6">
        <div class="flex items-center justify-between">
            <a href="/" class="flex" aria-label="Go to Skillmate homepage">
                <img src="{{ asset('assets/icons/skillmate.png') }}" alt="Skillmate logo" class="h-8">
            </a>
            @include('includes.user-dropdown')
        </div>
    </div>
</nav>
