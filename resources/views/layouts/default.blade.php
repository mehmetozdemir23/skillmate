@extends('layouts.app')
@section('app-content')
    @include('includes.navbar')
    <div class="h-screen flex pt-20">
        @include('includes.sidebar')
        <main class="relative w-full h-full overflow-auto lg:ml-64 p-4">
            @yield('default-content')
        </main>
    </div>
    <div class="lg:hidden px-3 py-2 text-xs mt-auto">
        Vectors and icons by <a
            href="https://www.figma.com/community/file/1166831539721848736?ref=svgrepo.com"
            target="_blank">Solar Icons</a> in CC Attribution License via <a href="https://www.svgrepo.com/"
            target="_blank">SVG Repo</a>
    </div>
@endsection
