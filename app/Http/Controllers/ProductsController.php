<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Support\ImageUpload;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $productsQuery = Product::query()->with('category');

        if ($search) {
            $productsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('category_name', 'like', "%{$search}%");
                    });
            });
        }

        $products = $productsQuery->simplePaginate(10)->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('category_name')->get();

        return view('products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['photo'] = ImageUpload::store($request->file('photo'), 'img/product');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    public function nav()
    {
        return view('products.nav');
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('products.view', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('category_name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['photo'] = ImageUpload::store(
                $request->file('photo'),
                'img/product',
                $product->photo
            );
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->photo) {
            ImageUpload::delete('img/product', $product->photo);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
