<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(EmployeeController::class)->group(function () {
    Route::get('/','login')->name('login');
    Route::post('/process/login','processLogin');
    Route::get('/logout', function () {
    return view('login.logout'); // return the logout confirmation view
    })->name('logout.get'); 
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(CustomerController::class)->group(function () {
    Route::get('/','login')->name('login');
    Route::post('/process/login','processLogin');
    Route::get('/logout', function () {
    return view('login.logout'); // return the logout confirmation view
    })->name('logout.get'); 
    Route::post('/logout', 'logout')->name('logout');
});