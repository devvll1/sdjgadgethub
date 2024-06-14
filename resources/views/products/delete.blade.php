@extends('layout.main')

@section('content')
@include('include.nav')
<div class="container">
    <form method="POST" action="{{ route('products.destroy', ['products' => $product->id]) }}">
        @csrf
        @method('DELETE')
        <p>Are you sure you want to delete this product?</p>
        <button type="submit" class="btn btn-danger">Delete Product</button>
    </form>
</div>

@endsection
