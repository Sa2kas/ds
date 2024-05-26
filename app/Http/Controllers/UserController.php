<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Inertia::render('UserManagement', compact('users'));
    }

    // Handles both creating and updating users.
    public function store(Request $request)
    {
        $id = $request->input('id'); // Check if an ID was provided.

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => $id ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
            'role' => 'required|string|max:255',
        ]);

        $data = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
        ];

        // Only add password to the array if it is provided and not null.
        if (!empty($validatedData['password'])) {
            $data['password'] = Hash::make($validatedData['password']);
        }

        // If there's an ID, we're updating an existing user, otherwise we're creating a new one.
        User::updateOrCreate(
            ['id' => $id], // Conditionally check if this is an update
            $data
        );

        return redirect()->back()->with('success', 'User saved successfully.');
    }

    // Remove the specified user from storage.
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
