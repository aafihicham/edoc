<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create token for new register
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Create token after auth
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful!',
            'token' => $token,
            'user' => [
            'id' => $user->id,
            'name' => $user->name,
            ]
        ]);
    }

    // Get authenticated user
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // Logout
    public function logout(Request $request)
    {
        // Delete actuale token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully!',
        ]);
    }
}