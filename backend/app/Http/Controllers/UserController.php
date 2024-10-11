<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'RoleId' => 'required|integer',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'RoleId' => $request->RoleId,
        ]);

        return response()->json($user, 201);
    }

    // Fetch all users
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Specific user
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Edit unique user
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
            'RoleId' => 'sometimes|required|integer',
        ]);

        $user = User::findOrFail($id);

        // Update data
        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->RoleId = $request->RoleId ?? $user->RoleId;
        
        $user->save();

        return response()->json($user);
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
 
        return response()->json(null, 204);
    }
}