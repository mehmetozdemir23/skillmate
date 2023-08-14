@extends('layouts.profile')
@section('profile-content')
    <div class="col-span-full xl:col-auto">
        @include('includes.toast')
        @include('includes.profile.avatar')
        @include('includes.profile.skills')
        @include('includes.profile.general-info')
        @include('includes.profile.password')
        @include('includes.profile.delete-account')
    </div>
@endsection
