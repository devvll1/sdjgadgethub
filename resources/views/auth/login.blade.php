@extends('layouts.guest')

@section('title', 'Sign in — SDJ Gadget Hub')

@section('content')
<div class="auth-card">
    <div class="auth-brand">
        <span class="auth-logo"><i class="bi bi-lightning-charge-fill"></i></span>
        <h1>SDJ Gadget Hub</h1>
        <p class="text-muted mb-0">Point of sale & inventory</p>
    </div>

    <h2 class="auth-heading">Sign in</h2>
    <p class="auth-subheading">Welcome back. Enter your credentials to continue.</p>

    @include('partials.auth-alerts')

    <form method="post" action="{{ route('login.store') }}" class="auth-form">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group input-group-lg">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required autofocus placeholder="your_username">
            </div>
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group input-group-lg">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
            </div>
        </div>
        <button type="submit" class="btn btn-dark btn-lg w-100">Sign in</button>
    </form>

    <p class="auth-footer text-center mt-4 mb-0">
        Don't have an account?
        <a href="{{ route('register') }}" class="fw-semibold">Create one</a>
    </p>
</div>
@endsection
