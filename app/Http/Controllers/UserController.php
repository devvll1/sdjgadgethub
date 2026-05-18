<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Gender;
use App\Models\User;
use App\Support\ImageUpload;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $usersQuery = User::query()->with('gender');

        if ($search) {
            $usersQuery->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhereHas('gender', function ($genderQuery) use ($search) {
                        $genderQuery->where('gender', 'like', "%{$search}%");
                    });
            });
        }

        $users = $usersQuery->simplePaginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $genders = Gender::orderBy('gender')->get();

        return view('users.create', compact('genders'));
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['photo'] = ImageUpload::store($request->file('photo'), 'img/user');
        }

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User added successfully.');
    }

    public function nav()
    {
        return view('users.nav');
    }

    public function show($id)
    {
        $user = User::with('gender')->findOrFail($id);

        return view('users.view', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $genders = Gender::orderBy('gender')->get();

        return view('users.edit', compact('user', 'genders'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['photo'] = ImageUpload::store(
                $request->file('photo'),
                'img/user',
                $user->photo
            );
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->photo) {
            ImageUpload::delete('img/user', $user->photo);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
