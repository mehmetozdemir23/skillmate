@extends('layouts.app')
@section('app-content')
    @include('includes.navbar')
    <div class="h-screen flex pt-20">
        @include('includes.sidebar')
        <main class="relative w-full h-full overflow-auto lg:ml-64 p-4">
            @yield('default-content')
        </main>
    </div>
@endsection
