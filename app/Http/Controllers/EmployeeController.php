<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function login() {
        return view('login.login');
    }

    public function processLogin(Request $request) {
        $validated =$request->validate([
            'username' => ['required', 'max:12'],
            'password' => ['required', 'max:15']
        ]);

        $employee = Employee::where('username', $validated['username'])
            ->first();

         if($employee && Hash::check($validated['password'], $employee->password) && auth()->attempt($validated)) {
            auth()->login($employee);
            $request->session()->regenerate();

            $this->setUserSession($employee);
            return redirect('/employees');
         }
         else {
            // Password does not match
            return redirect()->back()->with('error', 'Invalid username or password');
        }
    }

    public function setUserSession($user) {
        // Set full name of current user
        $myFullName = "";
    
        if (empty($user->middle_name)) {
            $myFullName = $user->first_name . ' ' . $user->last_name;
        } else {
            $myFullName = $user->first_name . ' ' . $user->middle_name[0] . '. ' . $user->last_name;
        }
    
        // Provide variables for every field of user and set session of user
        $data = [
            'user_id' => $user->user_id,
            'first_name' => $user->first_name,
            'middle_name' => $user->middle_name,
            'last_name' => $user->last_name, 
            'age' => $user->age,
            'email' => $user->email,
            'password' => $user->password,
            'myFullName' => $myFullName,
            'isLoggedIn' => true
        ];
    
        session($data);
    }
    
        public function logout(Request $request) {
            Auth()->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('message_success', 'Your account has been successfully logged out,');
        }
        public function anotherProcessLogout(Request $request) {
            auth()->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');

        } 
}
