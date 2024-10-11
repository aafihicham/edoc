<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'label' => $request->label,
        ]);

        return response()->json($category, 201);
    }

    // Get all categories
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    // Get a specific category by ID
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category, 200);
    }

    // Update a category
    public function update(Request $request, $id)
    {
        $request->validate([
            'label' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->label = $request->label;
        $category->save();

        return response()->json($category, 200);
    }

    // Delete a category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(null, 204);
    }
}
