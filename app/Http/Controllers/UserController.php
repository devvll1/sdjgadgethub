<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\storage;
use App\Models\User;
use App\Models\Gender;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;

    class UserController extends Controller
    {
        public function login() {
            return view('login.login');
        }
    
        public function processLogin(Request $request) {
            $validated =$request->validate([
                'username' => ['required', 'max:12'],
                'password' => ['required', 'max:15']
            ]);
    
            $user = User::where('username', $validated['username'])
                ->first();
    
             if($user && Hash::check($validated['password'], $user->password) && auth()->attempt($validated)) {
                auth()->login($user);
                $request->session()->regenerate();
    
                $this->setUserSession($user);
                return redirect('/dashboard');
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

        public function index(Request $request)
    {
        $search = $request->input('search');
        $usersQuery = User::query()->with('genders'); // Eager load the gender relationship
    
        if ($search) {
            $usersQuery->where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
                    
                if (strtolower($search) == 'male' || strtolower($search) == 'female') {
                    $query->orWhereHas('genders', function ($query) use ($search) {
                        $query->where('gender', $search);
                    });
                }
            });
        }
    
        $users = $usersQuery->simplePaginate(6); // Paginate the results
        $users->appends(['search' => $search]); // Append the search query to the pagination links
        return view('users.index', compact('users'));
    }

        public function create()
    {
        $genders = Gender::all();
        return view('users.create', compact('genders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'max:55'],
            'middle_name' => ['nullable', 'max:55'],
            'last_name' => ['required', 'max:55'],
            'suffix_name' => ['nullable', 'max:10'],
            'birth_date' => ['required', 'date'],
            'gender_id' => ['required'],
            'address' => ['required', 'max:55'],
            'contact_number' => ['required', 'numeric'],
            'email' => ['required', 'email'],
            'username' => ['required', 'max:12', Rule::unique('users', 'username')],
            'password' => ['required', 'max:15'],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password_confirmation' => ['required'],
        ], [
            'gender_id.required' => 'The gender field is required.'
        ]);
        if($request->hasFile('photo')) {
            $filenameWithExtension = $request->file('photo');
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameToStore = $filename . '' . time() . '' . $extension;
            $request->file('photo')->storeAs('public/img/user', $filenameToStore);
    
            $validated['photo'] = $filenameToStore;
        }

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('message_success', 'User successfully added.');
    }

    public function nav() {
        return view('users.nav');
    }

    public function show($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Return the view with the user data
        return view('users.view', compact('user'));
    }

    public function edit($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
        $genders = Gender::all();
        // Return the view with the user data
        return view('users.edit', compact('user', 'genders'));
    }

    public function update(Request $request, $id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'first_name' => ['required', 'max:55'],
            'middle_name' => ['nullable', 'max:55'],
            'last_name' => ['required', 'max:55'],
            'suffix_name' => ['nullable', 'max:10'],
            'birth_date' => ['required', 'date'],
            'gender_id' => ['required'],
            'address' => ['required', 'max:55'],
            'contact_number' => ['required', 'numeric'],
            'email' => ['required', 'email'],
            'username' => ['required', 'max:12', Rule::unique('users', 'username')->ignore($id, 'user_id')],
        ]);
    
        // Update the photo if a new photo is uploaded
        if ($request->hasFile('photo')) {
            $filenameWithExtension = $request->file('photo');
            $filename = pathinfo($filenameWithExtension->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $filenameWithExtension->getClientOriginalExtension();
            
            // Generate a unique filename
            $filenameToStore = $filename . '' . time() . '.' . $extension;
            
            // Store the uploaded file to the desired directory
            $request->file('photo')->storeAs('public/img/user', $filenameToStore);
            
            // Delete the old photo if it exists
            if ($user->photo && Storage::exists('public/img/user/' . $user->photo)) {
                Storage::delete('public/img/user/' . $user->photo);
            }
            
            // Update the photo column in the database with the new filename
            $user->photo = $filenameToStore;
        }
    
        // Update the user with the new data
        $user->update($validatedData);
        
        // Redirect back with a success message
        return redirect()->route('users.index')->with('message_success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        // Find the user by ID and delete it
        // Find the user by ID
        $user = User::findOrFail($id);

        // Delete the user's image if it exists
        if ($user->photo && Storage::exists('public/img/user/' . $user->photo)) {
            Storage::delete('public/img/user/' . $user->photo);
        }
        // Delete the user
        $user->delete();

    
        // Redirect back with a success message
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
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
