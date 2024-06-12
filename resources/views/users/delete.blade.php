@extends('layout.main')

@section('content')
@include('include.nav')
<div class="container">
    <form method="POST" action="{{ route('users.destroy', ['users' => $user->id]) }}">
        @csrf
        @method('DELETE')
        <p>Are you sure you want to delete this user?</p>
        <button type="submit" class="btn btn-danger">Delete User</button>
    </form>
</div>

@endsection
