<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PublisherController extends Controller
{
    /**
     * Display a listing of all publishers.
     */
    public function index()
    {
        try {
            $publishers = Publisher::with('user')->get();
            return response()->json([
                'status' => 'success',
                'message' => '📋 Publishers retrieved successfully.',
                'data' => [
                    'publishers' => $publishers
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve publishers.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new publisher.
     */
    public function register(Request $request)
    {
        try {
            Log::info('Incoming Request Data: ', $request->all());

            // Validate request data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Start a database transaction
            DB::beginTransaction();

            $data = $request->all();

            // Create the user in the users table
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']), // Hash the password
            ]);
            $user->assignRole('publisher'); // Assign role to the user

            // Create the publisher
            $publisher = Publisher::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            // Commit the transaction
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => '✅ Publisher created successfully.',
                'data' => [
                    'publisher' => [
                        'id' => $publisher->id,
                        'name' => $publisher->name,
                        'email' => $publisher->email,
                        'user_id' => $publisher->user_id,
                    ],
                ]
            ], 201);
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();
            Log::error('Failed to create publisher: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create publisher.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified publisher.
     */
    public function show($id)
    {
        try {
            $publisher = Publisher::with('user')->find($id);

            if (!$publisher) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Publisher not found.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => '🎉 Publisher retrieved successfully.',
                'data' => [
                    'publisher' => $publisher,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve publisher.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified publisher.
     */
    public function update(Request $request, $id)
    {
        try {
            // Find the publisher
            $publisher = Publisher::find($id);

            if (!$publisher) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Publisher not found.'
                ], 404);
            }

            // Find the associated user
            $user = User::find($publisher->user_id);

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Associated user not found.'
                ], 404);
            }

            // Validate request data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            // Prepare data
            $data = $request->only(['name', 'email', 'password']);

            // Update publisher details if name is provided
            if (isset($data['name'])) {
                $publisher->update([
                    'name' => $data['name'],
                ]);
            }

            // Update associated user details
            if (isset($data['email'])) {
                $user->update([
                    'email' => $data['email'],
                ]);
            }

            // If password is provided, update the password
            if (!empty($data['password'])) {
                $user->update([
                    'password' => Hash::make($data['password']),
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => '🔄 Publisher and associated user updated successfully.',
                'data' => [
                    'publisher' => $publisher,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update publisher and user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified publisher.
     */
    public function destroy($id)
    {
        try {
            // Find the publisher
            $publisher = Publisher::find($id);

            if (!$publisher) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Publisher not found.'
                ], 404);
            }

            // Find the associated user
            $user = User::find($publisher->user_id);

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Associated user not found.'
                ], 404);
            }

            // Delete the publisher
            $publisher->delete();

            // Delete the associated user
            $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => '🗑️ Publisher and associated user deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete publisher and user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
