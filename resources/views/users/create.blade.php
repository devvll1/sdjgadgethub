@extends('layout.main')

@section('content')

@include('include.nav')

<div class="container-fluid" style="padding: 0; min-height: 100vh; display: flex; flex-direction: column;">
    <div class="row justify-content-center flex-grow-1" style="margin: 0;">
        <div class="col-md-12" style="padding: 0;">
            <div class="form-container" style="background: linear-gradient(to right, rgba(255, 235, 59, 1), rgba(0, 0, 0, 1)); padding: 20px; min-height: 100vh;">
                <h1 class="mb-4" style="color: white; font-weight: bold;">Add User</h1>
                <form action="{{ route('users.store') }}" method="post" class="needs-validation" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        
                        <div class="col-md-4">
                            <label for="photo" class="form-label" style="color: white; font-weight: bold;">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" />
                            @error('photo') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="first_name" class="form-label" style="color: white; font-weight: bold;">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" />
                            @error('first_name') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="last_name" class="form-label" style="color: white; font-weight: bold;">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" />
                            @error('last_name') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="middle_name" class="form-label" style="color: white; font-weight: bold;">Middle Name</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name') }}" />
                            @error('middle_name') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-1">
                            <label for="suffix_name" class="form-label" style="color: white; font-weight: bold;">Suffix Name</label>
                            <input type="text" class="form-control" id="suffix_name" name="suffix_name" value="{{ old('suffix_name') }}" />
                            @error('suffix_name') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="birth_date" class="form-label" style="color: white; font-weight: bold;">Birth Date</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" />
                            @error('birth_date') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="gender_id" class="form-label" style="color: white; font-weight: bold;">Gender</label>
                            <select class="form-select" id="gender_id" name="gender_id">
                                <option value="" selected>Select Gender</option>
                                @foreach($genders as $gender)
                                    <option value="{{ $gender->gender_id }}">{{ $gender->gender }}</option>
                                @endforeach
                            </select>
                            @error('gender_id') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="contact_number" class="form-label" style="color: white; font-weight: bold;">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" />
                            @error('contact_number') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label" style="color: white; font-weight: bold;">Email Address</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" />
                            @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                
                        <div class="col-md-12">
                            <label for="address" class="form-label" style="color: white; font-weight: bold;">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                            @error('address') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="username" class="form-label" style="color: white; font-weight: bold;">Username</label>
                            <input type="text" class="form-control" id="username" name="username" />
                            @error('username') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="password" class="form-label" style="color: white; font-weight: bold;">Password</label>
                            <input type="password" class="form-control" id="password" name="password" />
                            @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="password_confirmation" class="form-label" style="color: white; font-weight: bold;">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" />
                            @error('password_confirmation') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-primary" href="{{ route('users.nav') }}">Return</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
