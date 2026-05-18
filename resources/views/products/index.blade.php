@extends('layout.main')

@section('title', 'Products — SDJ Gadget Hub')

@section('content')
@include('include.nav')
@include('partials.flash')

<div class="container-fluid page-shell">
    <div class="page-card">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1 font-display">Products</h1>
                <p class="text-muted mb-0">Manage inventory and pricing</p>
            </div>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Add product
            </a>
        </div>

        <form action="{{ route('products.index') }}" method="GET" class="row g-2 mb-4">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Search by name, description, or category..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary flex-grow-1">Search</button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <img src="{{ $product->photo ? asset('storage/img/product/' . $product->photo) : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png' }}"
                                     alt="{{ $product->name }}" class="product-thumb">
                            </td>
                            <td class="fw-semibold">{{ $product->name }}</td>
                            <td class="text-muted small">{{ Str::limit($product->description, 60) }}</td>
                            <td>₱{{ number_format($product->price, 2) }}</td>
                            <td>
                                <span class="badge {{ $product->stock_quantity > 0 ? 'text-bg-success' : 'text-bg-danger' }}">
                                    {{ $product->stock_quantity }}
                                </span>
                            </td>
                            <td>{{ $product->category?->category_name ?? '—' }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('products.show', $product->products_id) }}" class="btn btn-outline-primary">View</a>
                                    <a href="{{ route('products.edit', $product->products_id) }}" class="btn btn-outline-warning">Edit</a>
                                    <form action="{{ route('products.destroy', $product->products_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            {{ $products->links() }}
            <a href="{{ route('products.nav') }}" class="btn btn-secondary">Main menu</a>
        </div>
    </div>
</div>
@endsection
