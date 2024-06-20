<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;


// Group routes that require authentication
Route::middleware(['auth'])->group(function () {

    // Dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // User routes
    Route::controller(UserController::class)->group(function () {
        Route::get('/users/nav', 'nav')->name('users.nav');
        Route::get('/users', 'index')->name('users.index');
        Route::get('/users/create', 'create')->name('users.create');
        Route::post('/users/store', 'store')->name('users.store');
        Route::get('/users/{id}', 'show')->name('users.show');
        Route::get('/users/{id}/edit', 'edit')->name('users.edit');
        Route::put('/users/{id}', 'update')->name('users.update');
        Route::delete('/users/{id}', 'destroy')->name('users.destroy');
        Route::get('/full-name', 'showFullName')->name('full-name.show');
    });

    // Product routes
    Route::controller(ProductsController::class)->group(function () {
        Route::get('/products/nav', 'nav')->name('products.nav');
        Route::get('/products', 'index')->name('products.index');
        Route::get('/products/create', 'create')->name('products.create');
        Route::post('/products/store', 'store')->name('products.store');
        Route::get('/products/{id}', 'show')->name('products.show');
        Route::get('/products/{id}/edit', 'edit')->name('products.edit');
        Route::put('/products/{id}', 'update')->name('products.update');
        Route::delete('/products/{id}', 'destroy')->name('products.destroy');
    });
    
    Route::controller(ReportController::class)->group(function () {
        Route::get('/transactions/report', 'showReport')->name('transactions.report');
    
    });
    // Transaction routes
    Route::controller(TransactionsController::class)->group(function () {
        Route::get('/transactions/nav', 'nav')->name('transactions.nav');
        Route::get('/transactions', 'index')->name('transactions.index');
        Route::get('/transactions/history', 'history')->name('transactions.history');
        Route::get('/transactions/create', 'create')->name('transactions.create');
        Route::post('/transactions/store', 'store')->name('transactions.store');
        Route::get('/transactions/{id}', 'show')->name('transactions.show');
        Route::get('/transactions/{id}/edit', 'edit')->name('transactions.edit');
        Route::put('/transactions/{id}', 'update')->name('transactions.update');
        Route::delete('/transactions/{id}', 'destroy')->name('transactions.destroy');
        Route::get('/transactions/receipt/{transaction}', 'receipt')->name('transactions.receipt');

    });

   

});


// Public routes (do not require authentication)
Route::controller(UserController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::post('/process/login', 'processLogin');
    Route::get('/logout', function () {
        return view('login.logout'); // return the logout confirmation view
    })->name('logout.get'); 
    Route::post('/logout', 'logout')->name('logout');
});
