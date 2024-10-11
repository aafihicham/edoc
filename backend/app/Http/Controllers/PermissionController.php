<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'permissionName' => 'required|string|max:255',
            'description' => 'nullable|string',
            'edit_category' => 'nullable|string',
            'restoreDocument' => 'nullable|string',
            'deleteDocument' => 'nullable|string',
            'deleteCategory' => 'nullable|string',
        ]);

        $permission = Permission::create([
            'permissionName' => $request->permissionName,
            'description' => $request->description,
            'edit_category' => $request->edit_category,
            'restoreDocument' => $request->restoreDocument,
            'deleteDocument' => $request->deleteDocument,
            'deleteCategory' => $request->deleteCategory,
        ]);

        return response()->json($permission, 201);
    }
    public function index()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    public function show($id)
    {
        $permission = Permission::findOrFail($id);
        return response()->json($permission);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'permissionName' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'edit_category' => 'nullable|string',
            'restoreDocument' => 'nullable|string',
            'deleteDocument' => 'nullable|string',
            'deleteCategory' => 'nullable|string',
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update($request->all());

        return response()->json($permission);
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json(null, 204);
    }
}
