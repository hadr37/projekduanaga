@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    @auth
        <p>Halo, {{ Auth::user()->name }}! Selamat datang di dashboard.</p>
    @else
    @endauth
@endsection
