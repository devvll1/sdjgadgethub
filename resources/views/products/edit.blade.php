@extends('layout.main')

@section('content')

@include('include.nav')

<div class="container-fluid" style="padding: 0; min-height: 100vh; display: flex; flex-direction: column;">
    <div class="row justify-content-center flex-grow-1" style="margin: 0;">
        <div class="col-md-12" style="padding: 0;">
            <div class="form-container" style="background: linear-gradient(to right, rgba(255, 235, 59, 1), rgba(0, 0, 0, 1)); padding: 20px; min-height: 100vh;">
                <h1 class="mb-4" style="color: white; font-weight: bold;">Edit Information</h1>
                
                <form method="POST" action="{{ route('products.update', ['id' => $product->products_id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        
                        <div class="col-md-4">
                            <label for="photo" class="form-label" style="color: white; font-weight: bold;">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" />
                            @error('photo') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="name" class="form-label" style="color: white; font-weight: bold;">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" />
                            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="description" class="form-label" style="color: white; font-weight: bold;">Description</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{ old('description', $product->description) }}" />
                            @error('description') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="price" class="form-label" style="color: white; font-weight: bold;">Price</label>
                            <input type="text" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" />
                            @error('price') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="stock_quantity" class="form-label" style="color: white; font-weight: bold;">stock_quantity</label>
                            <input type="text" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" />
                            @error('stock_quantity') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="col-md-2">
                            <label for="category_id" class="form-label" style="color: white; font-weight: bold;">Category</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="" selected>Select Category</option>
                                @foreach($categories as $category_name)
                                <option value="{{ $category_name->category_id }}" {{ old('category_id', $product->category_id) == $category_name->category_id ? 'selected' : '' }}>{{ $category_name->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button class="btn btn-primary" href="{{ route('products.index') }}">Return</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
