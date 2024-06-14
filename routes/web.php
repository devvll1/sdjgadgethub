<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;



Route::controller(UserController::class)->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/','login')->name('login');
    Route::post('/process/login','processLogin');
    Route::get('/logout', function () {
    return view('login.logout'); // return the logout confirmation view
    })->name('logout.get'); 
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users/nav', [UserController::class, 'nav'])->name('users.nav');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', 'store')->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/full-name', [UserController::class, 'showFullName'])->name('full-name.show');
});

Route::controller(ProductsController::class)->group(function () {
    Route::get('/products/nav', [ProductsController::class, 'nav'])->name('products.nav');
    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('/products/store', 'store')->name('products.store');
    Route::get('/products/{id}', [ProductsController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductsController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
});
