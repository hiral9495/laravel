<!-- resources/views/dashboard/member.blade.php -->

@extends('main')

@section('content')
    <h1>Member Dashboard</h1>
    <p>Welcome to the Member dashboard!
    <b> {{ strtoupper($user->name) }}</b>
    </p>
@endsection
