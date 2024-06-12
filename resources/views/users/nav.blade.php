@extends('layout.main')

@section('content')

@include('include.nav')
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
<style>
    .header img {
        width: 100%;
        height: auto;
    }

    .header {
        max-width: 100%;
        display: flex;
        justify-content: center;
    }

    h1 {
    background: linear-gradient(to right, rgba(255, 235, 59, 1), rgba(0, 0, 0, 1));
    color: white;
    font-family: "Bebas Neue", sans-serif;
    font-size: 2.5rem;
    padding-top: 50px;
    text-align: center;
}

    .container-fluid {
        padding: 0;
    }

    .gradient-container {
        background: linear-gradient(to right, rgba(255, 235, 59, 1), rgba(0, 0, 0, 1));
        padding: 182px 0;
        text-align: center;
    }

    .btn-custom {
        border: 2px solid white;
        background: transparent;
        color: white;
        padding: 20px 100px;
        margin: 7                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           1px;
        font-family: "Bebas Neue", sans-serif;
        font-style: bold;
        font-size: 1.2rem;
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-custom:hover {
        background-color: white;
        color: black;
    }
</style>

<div class="container-fluid">
    <div class="header">
        <a href="#"><img style="width:1520px" src="{{ asset('img/header.png') }}" alt="Header Image"></a>
    </div>

    <div>
      <h1>Welcome, {{ session('myFullName') }}!</h1>  
    </div>

    <div class="gradient-container">
        <a  href="{{ route('users.create') }}" class="btn btn-custom">ADD USERS</a>
        <a href="{{ route('users.index') }}" class="btn btn-custom">USERS LIST</a>
        <div class="container">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="margin-top:20px"> Return</a>
        </div>
    </div>
    
    
    @yield('page-content')
    @csrf
</div>
@endsection
