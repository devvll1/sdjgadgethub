<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Gender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');
        $user = User::where('username', $credentials['username'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Invalid username or password.');
        }

        Auth::login($user);
        $request->session()->regenerate();
        session(['myFullName' => $user->full_name, 'isLoggedIn' => true]);

        return redirect()->intended(route('dashboard'));
    }

    public function showRegister()
    {
        $genders = Gender::orderBy('gender')->get();

        return view('auth.register', compact('genders'));
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated() + ['role' => 'cashier']);

        Auth::login($user);
        $request->session()->regenerate();
        session(['myFullName' => $user->full_name, 'isLoggedIn' => true]);

        return redirect()->route('dashboard')->with('success', 'Welcome! Your account has been created.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
