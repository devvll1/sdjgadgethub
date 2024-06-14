<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\storage;
use App\Models\User;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;


class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $productsQuery = Product::query()->with('categories'); // Eager load the gender relationship
    
        if ($search) {
            $productsQuery->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
                    
                if (strtolower($search) == 'laptops' || strtolower($search) == 'phones' ||
                 strtolower($search) == 'tablets' || strtolower($search) == 'watchs') {
                    $query->orWhereHas('categories', function ($query) use ($search) {
                        $query->where('category_name', $search);
                    });
                }
            });
        }
    
        $products = $productsQuery->simplePaginate(6); // Paginate the results
        $products->appends(['search' => $search]); // Append the search query to the pagination links
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => ['required', 'max:55'],
            'description' => ['nullable', 'max:255'],
            'price' => ['required', 'max:55'],
            'stock_quantity' => ['required'],
            'category_id' => ['required'],
            
        ], [
            'category_id.required' => 'The category field is required.'
        ]);
        if($request->hasFile('photo')) {
            $filenameWithExtension = $request->file('photo');
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameToStore = $filename . '' . time() . '' . $extension;
            $request->file('photo')->storeAs('public/img/product', $filenameToStore);
    
            $validated['photo'] = $filenameToStore;
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('message_success', 'Product successfully added.');
    }

    public function nav() {
        return view('products.nav');
    }

    public function show($id)
    {
        // Find the user by ID
        $product = Product::findOrFail($id);

        // Return the view with the user data
        return view('products.view', compact('product'));
    }

    public function edit($id)
    {
        // Find the user by ID
        $product = Product::findOrFail($id);
        $categories = Category::all();
        // Return the view with the user data
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Find the user by ID
        $product = Product::findOrFail($id);
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => ['required'],
            'description' => ['nullable', 'max:255'],
            'price' => ['required'],
            'stock_quantity' => ['required'],
            'category_id' => ['required'],

        ]);
    
        // Update the photo if a new photo is uploaded
        if ($request->hasFile('photo')) {
            $filenameWithExtension = $request->file('photo');
            $filename = pathinfo($filenameWithExtension->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $filenameWithExtension->getClientOriginalExtension();
            
            // Generate a unique filename
            $filenameToStore = $filename . '' . time() . '.' . $extension;
            
            // Store the uploaded file to the desired directory
            $request->file('photo')->storeAs('public/img/product', $filenameToStore);
            
            // Delete the old photo if it exists
            if ($product->photo && Storage::exists('public/img/product/' . $product->photo)) {
                Storage::delete('public/img/product/' . $product->photo);
            }
            
            // Update the photo column in the database with the new filename
            $product->photo = $filenameToStore;
        }
    
        // Update the product with the new data
        $product->update($validatedData);
        
        // Redirect back with a success message
        return redirect()->route('products.index')->with('message_success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        // Find the user by ID and delete it
        // Find the user by ID
        $product = Product::findOrFail($id);

        // Delete the product's image if it exists
        if ($product->photo && Storage::exists('public/img/product/' . $product->photo)) {
            Storage::delete('public/img/product/' . $product->photo);
        }
        // Delete the product
        $product->delete();

    
        // Redirect back with a success message
        return redirect()->route('products.index')->with('success', 'product deleted successfully.');
    }

}


