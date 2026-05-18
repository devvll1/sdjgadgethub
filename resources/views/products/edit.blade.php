@extends('layout.main')

@section('title', 'Edit product — SDJ Gadget Hub')

@section('content')
@include('include.nav')
@include('partials.flash')

<div class="container-fluid page-shell">
    <x-admin-form
        title="Edit product"
        subtitle="{{ $product->name }}"
        :action="route('products.update', $product->products_id)"
        method="PUT"
        :back-url="route('products.index')"
        submit-label="Save changes"
        :enctype="true"
    >
        <div class="row g-3">
            <div class="col-md-4">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                @error('photo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-8">
                <label for="name" class="form-label">Product name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="2">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="col-md-4">
                <label for="price" class="form-label">Price (₱)</label>
                <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="stock_quantity" class="form-label">Stock quantity</label>
                <input type="number" min="0" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                @error('stock_quantity')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">Select category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}" @selected(old('category_id', $product->category_id) == $category->category_id)>{{ $category->category_name }}</option>
                    @endforeach
                </select>
                @error('category_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
        </div>
    </x-admin-form>
</div>
@endsection
