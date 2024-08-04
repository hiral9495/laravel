<!-- resources/views/dashboard/superAdmin.blade.php -->

@extends('main')

@section('content')
    <h1>Super Admin Dashboard</h1>
    <p>Welcome to the Super Admin dashboard!<b> {{ strtoupper($user->name) }}</b></p>
@endsection
