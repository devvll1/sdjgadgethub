@extends('layouts.guest')

@section('title', 'Sign up — SDJ Gadget Hub')

@section('content')
<div class="auth-card auth-card-wide">
    <div class="auth-brand mb-3">
        <span class="auth-logo"><i class="bi bi-lightning-charge-fill"></i></span>
        <h1>Create account</h1>
        <p class="text-muted mb-0">Join SDJ Gadget Hub in a few steps</p>
    </div>

    @include('partials.auth-alerts')

    <form method="post" action="{{ route('register') }}" class="auth-form">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="first_name">First name</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                @error('first_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="last_name">Last name</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                @error('last_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="middle_name">Middle name <span class="text-muted">(optional)</span></label>
                <input type="text" id="middle_name" name="middle_name" class="form-control" value="{{ old('middle_name') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="suffix_name">Suffix <span class="text-muted">(optional)</span></label>
                <input type="text" id="suffix_name" name="suffix_name" class="form-control" value="{{ old('suffix_name') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required>
                @error('username')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="birth_date">Birth date</label>
                <input type="date" id="birth_date" name="birth_date" class="form-control" value="{{ old('birth_date') }}" required>
                @error('birth_date')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="gender_id">Gender</label>
                <select id="gender_id" name="gender_id" class="form-select" required>
                    <option value="">Select gender</option>
                    @foreach ($genders as $gender)
                        <option value="{{ $gender->gender_id }}" @selected(old('gender_id') == $gender->gender_id)>{{ $gender->gender }}</option>
                    @endforeach
                </select>
                @error('gender_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="contact_number">Contact number</label>
                <input type="text" id="contact_number" name="contact_number" class="form-control" value="{{ old('contact_number') }}" required>
                @error('contact_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label class="form-label" for="address">Address</label>
                <textarea id="address" name="address" class="form-control" rows="2" required>{{ old('address') }}</textarea>
                @error('address')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="password_confirmation">Confirm password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn btn-dark btn-lg w-100 mt-4">Create account</button>
    </form>

    <p class="auth-footer text-center mt-4 mb-0">
        Already have an account?
        <a href="{{ route('login') }}" class="fw-semibold">Sign in</a>
    </p>
</div>
@endsection
