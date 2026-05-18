@extends('layout.main')

@section('title', 'Orders — SDJ Gadget Hub')

@section('content')
@include('include.nav')
@include('partials.flash')

<div class="container-fluid page-shell">
    @include('partials.hub-menu', [
        'title' => 'Orders',
        'buttons' => [
            ['label' => 'Transactions', 'url' => route('transactions.index')],
            ['label' => 'History', 'url' => route('transactions.history')],
            ['label' => 'New sale', 'url' => route('transactions.create')],
            ['label' => 'Reports', 'url' => route('transactions.report')],
            ['label' => 'Back to dashboard', 'url' => route('dashboard')],
        ],
    ])
</div>
@endsection
