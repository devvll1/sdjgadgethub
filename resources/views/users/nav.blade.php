@extends('layout.main')

@section('title', 'Users — SDJ Gadget Hub')

@section('content')
@include('include.nav')
@include('partials.flash')

<div class="container-fluid page-shell">
    @include('partials.hub-menu', [
        'title' => 'Users',
        'buttons' => [
            ['label' => 'User list', 'url' => route('users.index')],
            ['label' => 'Add user', 'url' => route('users.create')],
            ['label' => 'Back to dashboard', 'url' => route('dashboard')],
        ],
    ])
</div>
@endsection
