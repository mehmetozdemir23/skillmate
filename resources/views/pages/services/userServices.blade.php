@extends('layouts.default')
@section('default-content')
    <section class="px-4 pb-4">
        @include('includes.toast')
        @include('includes.services.settings-bar')
        @foreach ($userServices as $service)
            <x-service-list-item :service="$service" />
        @endforeach
    </section>
@endsection
