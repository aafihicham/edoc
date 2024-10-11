<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        return response()->json($role, 201);
    }

    // List all roles (GET /roles)
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles, 200);
    }

     // Show a single role (GET /roles/{id})
     public function show($id)
     {
         $role = Role::findOrFail($id);
         return response()->json($role, 200);
     }

     // Update a role (PUT/PATCH /roles/{id})
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->all());

        return response()->json($role, 200);
    }

    // Delete a role (DELETE /roles/{id})
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully'], 200);
    }
}
