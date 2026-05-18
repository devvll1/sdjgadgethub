@extends('layout.main')

@section('title', 'Edit user — SDJ Gadget Hub')

@section('content')
@include('include.nav')
@include('partials.flash')

<div class="container-fluid page-shell">
    <x-admin-form
        title="Edit user"
        subtitle="Update account details"
        :action="route('users.update', $user->user_id)"
        method="PUT"
        :back-url="route('users.index')"
        submit-label="Save changes"
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
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                @error('first_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="last_name" class="form-label">Last name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                @error('last_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="middle_name" class="form-label">Middle name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}">
            </div>
            <div class="col-md-4">
                <label for="suffix_name" class="form-label">Suffix</label>
                <input type="text" class="form-control" id="suffix_name" name="suffix_name" value="{{ old('suffix_name', $user->suffix_name) }}">
            </div>
            <div class="col-md-4">
                <label for="birth_date" class="form-label">Birth date</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}" required>
                @error('birth_date')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="gender_id" class="form-label">Gender</label>
                <select class="form-select" id="gender_id" name="gender_id" required>
                    <option value="">Select gender</option>
                    @foreach($genders as $gender)
                        <option value="{{ $gender->gender_id }}" @selected(old('gender_id', $user->gender_id) == $gender->gender_id)>{{ $gender->gender }}</option>
                    @endforeach
                </select>
                @error('gender_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
        </div>

        <p class="form-section-title">Contact & account</p>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="contact_number" class="form-label">Contact number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}" required>
                @error('contact_number')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="2" required>{{ old('address', $user->address) }}</textarea>
                @error('address')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                @error('username')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="cashier" @selected(old('role', $user->role) === 'cashier')>Cashier</option>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                </select>
                @error('role')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
        </div>
    </x-admin-form>
</div>
@endsection
