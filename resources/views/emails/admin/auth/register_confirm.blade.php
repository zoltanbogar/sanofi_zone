@extends('layouts.email')

@section('content')
    <p class="dear">Hi <strong>{!! $name !!}</strong></p>

    <p>You have been created as an admin at Zone Access Rigths Application</p>
    <p>
        Please click
        <a href="{{ url('/auth/register/confirm/'.$token) }}">here</a>
        to activate your account
    </p>
@stop