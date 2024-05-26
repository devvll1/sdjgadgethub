<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

    class UserController extends Controller
    {
        public function login() {
            return view('login.login');
        }
    }
