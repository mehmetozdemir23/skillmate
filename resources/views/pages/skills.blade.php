@extends('layouts.profile')
@section('profile-content')
    @foreach ($skills as $skill)
        {{ $skill->name }}
    @endforeach
@endsection
