@extends('layouts.default')
@section('default-content')
    @include('includes.toast')
    @include('includes.profile.avatar')
    @include('includes.profile.skills')
    @include('includes.profile.info')
    @include('includes.profile.password')
    @include('includes.profile.delete-account')
@endsection
