@extends('layout.main')

@section('content')

@include('include.nav')

<div class="container">
    <div class="row justify-content-center">

        <!-- Main Content -->
        <div class="col-md-10 mt-4">
            <h2>Product Details</h2>
            
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Description</th>
                        <td>{{ $product->description }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Price</th>
                        <td>{{ $product->price }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Stock Quantity</th>
                        <td>{{ $product->stock_quantity }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Category</th>
                        <td>{{ $product->categories->category_name }}</td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Return Button -->
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Return</a>
        </div>
    </div>
</div>
@endsection