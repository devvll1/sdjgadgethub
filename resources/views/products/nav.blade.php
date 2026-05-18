@extends('layout.main')

@section('title', 'Products — SDJ Gadget Hub')

@section('content')
@include('include.nav')
@include('partials.flash')

<div class="container-fluid page-shell">
    @include('partials.hub-menu', [
        'title' => 'Products',
        'buttons' => [
            ['label' => 'Product list', 'url' => route('products.index')],
            ['label' => 'Add product', 'url' => route('products.create')],
            ['label' => 'Back to dashboard', 'url' => route('dashboard')],
        ],
    ])
</div>
@endsection
