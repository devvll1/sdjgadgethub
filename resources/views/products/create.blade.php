@extends('layout.main')

@section('content')

@include('include.nav')

<div class="container-fluid" style="padding: 0; min-height: 100vh; display: flex; flex-direction: column;">
    <div class="row justify-content-center flex-grow-1" style="margin: 0;">
        <div class="col-md-12" style="padding: 0;">
            <div class="form-container" style="background: linear-gradient(to right, rgba(255, 235, 59, 1), rgba(0, 0, 0, 1)); padding: 20px; min-height: 100vh;">
                <h1 class="mb-4" style="color: white; font-weight: bold;">Add Product</h1>
                <form action="{{ route('products.store') }}" method="post" class="needs-validation" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        
                        <div class="col-md-4">
                            <label for="photo" class="form-label" style="color: white; font-weight: bold;">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" />
                            @error('photo') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="name" class="form-label" style="color: white; font-weight: bold;">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" />
                            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="description" class="form-label" style="color: white; font-weight: bold;">Description</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" />
                            @error('description') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="price" class="form-label" style="color: white; font-weight: bold;">Price</label>
                            <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}" />
                            @error('price') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-1">
                            <label for="stock_quantity" class="form-label" style="color: white; font-weight: bold; font-size:15px ">Stock Quantity</label>
                            <input type="text" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" />
                            @error('stock_quantity') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="col-md-2">
                            <label for="category_id" class="form-label" style="color: white; font-weight: bold;">Category</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="" selected>Select Category</option>
                                @foreach($categories as $category_name)
                                    <option value="{{ $category_name->category_id }}">{{ $category_name->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>

                        
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>

                        <div class="col-md-1 d-flex align-items-end">
                            <a class="btn btn-primary" href="{{ route('products.index') }}">Return</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
