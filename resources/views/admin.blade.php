<!-- resources/views/dashboard/admin.blade.php -->

@extends('main')

@section('content')
    <h1>Admin Dashboard</h1>
    <p>
        Welcome to the Admin dashboard!
        <b> {{ strtoupper($user->name) }}</b>

    </p>
@endsection
