<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(UserController::class)->middleware('role:admin')->group(function () {
        Route::get('/users/nav', 'nav')->name('users.nav');
        Route::get('/users', 'index')->name('users.index');
        Route::get('/users/create', 'create')->name('users.create');
        Route::post('/users/store', 'store')->name('users.store');
        Route::get('/users/{id}', 'show')->name('users.show');
        Route::get('/users/{id}/edit', 'edit')->name('users.edit');
        Route::put('/users/{id}', 'update')->name('users.update');
        Route::delete('/users/{id}', 'destroy')->name('users.destroy');
    });

    Route::controller(ProductsController::class)->middleware('role:admin')->group(function () {
        Route::get('/products/nav', 'nav')->name('products.nav');
        Route::get('/products', 'index')->name('products.index');
        Route::get('/products/create', 'create')->name('products.create');
        Route::post('/products/store', 'store')->name('products.store');
        Route::get('/products/{id}', 'show')->name('products.show');
        Route::get('/products/{id}/edit', 'edit')->name('products.edit');
        Route::put('/products/{id}', 'update')->name('products.update');
        Route::delete('/products/{id}', 'destroy')->name('products.destroy');
    });

    Route::controller(ReportController::class)->middleware('role:admin')->group(function () {
        Route::get('/transactions/report', 'showReport')->name('transactions.report');
    });

    Route::controller(TransactionsController::class)->group(function () {
        Route::get('/transactions/nav', 'nav')->name('transactions.nav');
        Route::get('/transactions', 'index')->middleware('role:admin')->name('transactions.index');
        Route::get('/transactions/history', 'history')->name('transactions.history');
        Route::get('/transactions/create', 'create')->name('transactions.create');
        Route::post('/transactions/store', 'store')->name('transactions.store');
        Route::get('/transactions/receipt/{transaction}', 'receipt')->name('transactions.receipt');
        Route::get('/transactions/{id}', 'show')->middleware('role:admin')->name('transactions.show');
        Route::get('/transactions/{id}/edit', 'edit')->middleware('role:admin')->name('transactions.edit');
        Route::put('/transactions/{id}', 'update')->middleware('role:admin')->name('transactions.update');
        Route::delete('/transactions/{id}', 'destroy')->middleware('role:admin')->name('transactions.destroy');
    });
});
