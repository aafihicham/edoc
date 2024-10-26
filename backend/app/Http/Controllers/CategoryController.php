<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            return response()->json(['error' => 'Unauthorized', 'message' => $e->getMessage()], 401);
        }

        $request->validate(['label' => 'required|string|max:255']);

        $category = Category::create([
            'label' => $request->label,
            'user_id' => $user->id,
        ]);

        return response()->json($category, 201);
    }

    public function index()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get the authenticated user
        $user = JWTAuth::user();
        $categories = Category::where('user_id', $user->id)->get();

        return response()->json($categories, 200);
    }

    public function show($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get the authenticated user
        $user = JWTAuth::user();
        $category = Category::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        return response()->json($category, 200);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate(['label' => 'required|string|max:255']);

        // Get the authenticated user
        $user = JWTAuth::user();
        $category = Category::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        
        $category->update(['label' => $request->label]);

        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get the authenticated user
        $user = JWTAuth::user();
        $category = Category::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        
        $category->delete();

        return response()->json(null, 204);
    }
}
