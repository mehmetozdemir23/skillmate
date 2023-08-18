@extends('layouts.app')
@section('app-content')
    <section class="bg-gray-50 ">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="/" class="mb-6">
                <img class="h-10 mr-2" src="{{ asset('assets/icons/skillmate.png') }}" alt="logo">
            </a>
            <div class="w-full bg-white rounded-lg shadow  md:mt-0 sm:max-w-md xl:p-0  ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl ">
                        Create and account
                    </h1>
                    <form class="space-y-4 md:space-y-6" method="post" action="{{ route('register') }}">
                        @csrf
                        <x-form-input id="name" name="name" label="Name" required=true />
                        <x-form-input type="email" id="email" name="email" label="Your email" required=true />
                        <x-form-input type="password" id="password" name="password" label="Password" required=true />
                        <x-form-input type="password" id="password_confirmation" name="password_confirmation"
                            label="Confirm Password" required=true />
                        <x-button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center   ">Create
                            an account</x-button>
                        <p class="text-sm font-light text-gray-500 ">
                            Already have an account? <a href="{{ route('login') }}"
                                class="font-medium text-blue-600 hover:underline ">Login here</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
