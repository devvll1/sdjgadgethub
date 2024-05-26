<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/','login')->name('login');
    Route::post('/process/login','processLogin');
    Route::get('/logout', function () {
    return view('login.logout'); // return the logout confirmation view
    })->name('logout.get'); 
    Route::post('/logout', 'logout')->name('logout');
});
