<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => '🎉 Registration successful! Welcome ' . $user->name . '!',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // Login a user
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        // Use auth() to get the currently authenticated user
        $user = JWTAuth::user();
        
        // Log the user's roles for debugging
        Log::info('User Roles:', $user->getRoleNames()->toArray());

        $roles = $user->getRoleNames();
        $publisher_id = $user->publisher ? $user->publisher->id : null;

        return response()->json([
            'token' => $token,
            'roles' => $roles,
            'user' => [
                'publisher_id' => $publisher_id, 
                'name' => $user->name,
            ],
            'message' => '🔐 Login successful! Welcome back, ' . $user->name . '!',
        ], 200);
    }

    // Logout the user (invalidate token)
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'message' => '👋 Logout successful! Come back soon!',
            ], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to log out, please try again.'], 500);
        }
    }
}
