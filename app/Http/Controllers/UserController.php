<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        $total = User::count();
        return view('users.index', compact(['users', 'total']));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:users,phone',
            'usertype' => 'required',
            'password' => 'required|min:8',
        ]);

        $validation['password'] = bcrypt($validation['password']);

        $user = User::create($validation);

        if ($user) {
            session()->flash('success', 'User added successfully.');
            return redirect(route('users.index'));
        } else {
            session()->flash('error', 'There was a problem adding the user.');
            return redirect(route('users.create'));
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validation = $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:users,phone,' . $id,
            'usertype' => 'required',
        ]);

        if ($request->filled('password')) {
            $validation['password'] = bcrypt($request->password);
        }

        $user->update($validation);

        if ($user) {
            session()->flash('success', 'User updated successfully.');
            return redirect(route('users.index'));
        } else {
            session()->flash('error', 'There was a problem updating the user.');
            return redirect(route('users.edit', $id));
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if ($user) {
            session()->flash('success', 'User deleted successfully.');
            return redirect(route('users.index'));
        } else {
            session()->flash('error', 'There was a problem deleting the user.');
            return redirect(route('users.index'));
        }
    }
}
