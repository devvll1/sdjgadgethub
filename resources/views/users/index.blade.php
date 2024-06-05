@extends('layout.main')

@section('content')

@include('include.nav')

<div class="container-fluid">
    <div class="row">
        <!-- Pagination Links and Search Form -->
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 mt-4 mb-3">
                    <!-- Pagination Links -->
                    {{ $users->links() }}
                </div>
                <!-- Search Form -->
                <form action="{{ route('users.index') }}" method="GET" class="search-form col-md-6 mt-3 mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- User Table -->
        <div class="table-responsive col-md-12">
            <table class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th>Profile Image</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Middle Name</th>
                        <th>Suffix Name</th>
                        <th>Birth Date</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>Email Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <img src="{{ ($user->photo) ? asset('storage/img/user/' . $user->photo) : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png' }}"
                                        class="img-fluid" width="70" height="78" />
                            </td>                                  
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $user->first_name }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $user->last_name }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $user->middle_name }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $user->suffix_name }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ date('M d, Y', strtotime($user->birth_date)) }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $user->genders->gender }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $user->address }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $user->contact_number }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $user->email }}</td>
                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="User Actions">
                                    <a href="{{ route('users.show', $user->user_id) }}" class="btn btn-primary btn-sm">View</a>
                                    <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Return button -->
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Return</a>
        </div>
    </div>
</div>

@endsection
