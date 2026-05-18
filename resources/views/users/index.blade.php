@extends('layout.main')

@section('title', 'Users — SDJ Gadget Hub')

@section('content')
@include('include.nav')
@include('partials.flash')

<div class="container-fluid page-shell">
    <div class="page-card">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1 font-display">Users</h1>
                <p class="text-muted mb-0">Manage staff accounts</p>
            </div>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i> Add user
            </a>
        </div>

        <form action="{{ route('users.index') }}" method="GET" class="row g-2 mb-4">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Search name, email, username, or gender..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary flex-grow-1">Search</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Gender</th>
                        <th>Contact</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <img src="{{ $user->photo ? asset('storage/img/user/' . $user->photo) : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png' }}"
                                     alt="{{ $user->full_name }}" class="product-thumb">
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $user->full_name }}</div>
                                <small class="text-muted">{{ $user->birth_date?->format('M d, Y') }}</small>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td><span class="badge text-bg-{{ $user->role === 'admin' ? 'dark' : 'info' }}">{{ ucfirst($user->role) }}</span></td>
                            <td>{{ $user->gender?->gender ?? '—' }}</td>
                            <td>{{ $user->contact_number }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('users.show', $user->user_id) }}" class="btn btn-outline-primary">View</a>
                                    <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-outline-warning">Edit</a>
                                    <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            {{ $users->links() }}
            <a href="{{ route('users.nav') }}" class="btn btn-secondary">Main menu</a>
        </div>
    </div>
</div>
@endsection
