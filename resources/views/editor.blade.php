<!-- resources/views/dashboard/editor.blade.php -->

@extends('main')

@section('content')
    <h1>Editor Dashboard</h1>
    <p>Welcome to the Editor dashboard!
    <b> {{ strtoupper($user->name) }}</b>
    </p>
@endsection