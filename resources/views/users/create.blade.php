@extends('layout.main')

@section('title', 'Add user — SDJ Gadget Hub')

@section('content')
@include('include.nav')
@include('partials.flash')

<div class="container-fluid page-shell">
    <x-admin-form
        title="Add user"
        subtitle="Create a new staff account"
        :action="route('users.store')"
        :back-url="route('users.index')"
        submit-label="Create user"
        :enctype="true"
    >
        <p class="form-section-title">Profile</p>
<div class="row g-3">
<div class="col-md-4">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                @error('photo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
<div class="col-md-4">
                <label for="first_name" class="form-label">First name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                @error('first_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
<div class="col-md-4">
                <label for="last_name" class="form-label">Last name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                @error('last_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
<div class="col-md-4">
                <label for="middle_name" class="form-label">Middle name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name') }}">
</div>
<div class="col-md-4">
                <label for="suffix_name" class="form-label">Suffix</label>
                <input type="text" class="form-control" id="suffix_name" name="suffix_name" value="{{ old('suffix_name') }}">
</div>
<div class="col-md-4">
                <label for="birth_date" class="form-label">Birth date</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                @error('birth_date')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
<div class="col-md-4">
                <label for="gender_id" class="form-label">Gender</label>
                <select class="form-select" id="gender_id" name="gender_id" required>
                    <option value="">Select gender</option>
                    @foreach($genders as $gender)
                        <option value="{{ $gender->gender_id }}" @selected(old('gender_id') == $gender->gender_id)>{{ $gender->gender }}</option>
                    @endforeach
                </select>
                @error('gender_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
</div>
        <p class="form-section-title">Contact & account</p>
<div class="row g-3">
<div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
                <label for="contact_number" class="form-label">Contact number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" required>
                @error('contact_number')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
<div class="col-12">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="2" required>{{ old('address') }}</textarea>
                @error('address')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
<div class="col-md-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                @error('username')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
<div class="col-md-4">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="cashier" @selected(old('role', 'cashier') === 'cashier')>Cashier</option>
                    <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                </select>
                @error('role')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
<div class="col-md-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
<div class="col-md-4">
                <label for="password_confirmation" class="form-label">Confirm password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
</div>
</div>
    </x-admin-form>
</div>
@endsection
