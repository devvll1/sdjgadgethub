@extends('layout.main')

@section('title', 'Login — SDJ Gadget Hub')

@section('content')
<div class="login-page">
    <div class="login-card row g-0">
        <div class="col-md-5 login-brand-panel">
            <img src="{{ asset('img/login.png') }}" alt="SDJ Gadget Hub">
        </div>
        <div class="col-md-7 login-form-panel">
            <h1 class="mb-1">SDJ Gadget Hub</h1>
            <h2 class="h4 mb-4">Sign in</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label fw-semibold">Username</label>
                    <input type="text" id="username" name="username" class="form-control form-control-lg" value="{{ old('username') }}" required autofocus>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" id="password" name="password" class="form-control form-control-lg" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 brand-login-btn">
                    Sign in
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
