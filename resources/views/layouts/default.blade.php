@extends('layouts.app')
@section('app-content')
    @include('includes.navbar')
    <div class="h-screen flex pt-20 bg-gray-50 dark:bg-gray-900">
        @include('includes.sidebar')
        <main class="relative w-full h-full overflow-auto bg-gray-50 lg:ml-64 dark:bg-gray-900 p-4">
            @yield('default-content')
        </main>
    </div>
@endsection
