<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function lock($id)
    {
        $user = User::find($id);
        $user->is_locked = !$user->is_locked;
        $user->save();

        $status = $user->is_locked ? 'locked' : 'unlocked';
        return redirect()->back()->with('success', "User has been {$status}.");
    }

    public function unlock($id)
    {
        $user = User::find($id);
        $user->is_locked = false;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User unlocked successfully.');
    }

    public function approve($id)
    {
        $user = User::find($id);
        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('success', 'User approved successfully.');
    }


    public function reject($id)
    {
        $user = User::find($id);
        $user->is_approved = false;
        $user->save();


        return redirect()->route('users.index')->with('success', 'User rejected successfully.');
    }
}
