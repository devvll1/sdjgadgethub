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
                    {{ $products->links() }}
                </div>
                <!-- Search Form -->
                <form action="{{ route('products.index') }}" method="GET" class="search-form col-md-6 mt-3 mb-3">
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
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock Quantity</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <img src="{{ ($product->photo) ? asset('storage/img/product/' . $product->photo) : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png' }}"
                                        class="img-fluid" width="70" height="78" />
                            </td>                                  
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $product->name }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $product->description }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $product->price }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $product->stock_quantity }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $product->categories->category_name }}</td>
                        
                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="product Actions">
                                    <a href="{{ route('products.show', $product->products_id) }}" class="btn btn-primary btn-sm">View</a>
                                    <a href="{{ route('products.edit', $product->products_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('products.destroy', $product->products_id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Product?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Return button -->
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Return</a>
            <a class="btn btn-secondary" href="{{ route('products.nav') }}">Main Menu</a>
        </div>
    </div>
</div>

@endsection