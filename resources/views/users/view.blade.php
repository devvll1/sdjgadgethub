@extends('layout.main')

@section('content')

@include('include.nav')

<div class="container">
    <div class="row justify-content-center">

        <!-- Main Content -->
        <div class="col-md-10 mt-4">
            <h2>User Details</h2>
            
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">First Name</th>
                        <td>{{ $user->first_name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Middle Name</th>
                        <td>{{ $user->middle_name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Last Name</th>
                        <td>{{ $user->last_name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Birth Date</th>
                        <td>{{ $user->birth_date }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Gender</th>
                        <td>{{ $user->genders->gender }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Address</th>
                        <td>{{ $user->address }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Contact Number</th>
                        <td>{{ $user->contact_number }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Email Address</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Return Button -->
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Return</a>
        </div>
    </div>
</div>
@endsection