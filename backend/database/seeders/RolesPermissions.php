<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesPermissions extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        
       
        $permissions = [
            'view documents', 'create documents', 'edit documents', 'delete documents', 
            'view categories', 'create categories', 'edit categories', 'delete categories', 
            'view publishers', 'create publishers', 'edit publishers', 'delete publishers', 
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'api']);
        }

        // Define roles and their permissions
        $roles = [
            'admin' => [
                'view documents', 'create documents', 'edit documents', 'delete documents', 
                'view categories', 'create categories', 'edit categories', 'delete categories', 
                'view publishers', 'create publishers', 'edit publishers', 'delete publishers', 
            ],
            'publisher' => [
                'view documents', 'create documents', 'edit documents', 'delete documents', 
                'view categories', 'create categories','edit categories', 'delete categories',
                'view publishers','edit publishers'
            ]
        ];

        // Create roles and assign permissions
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'api']);
            $role->givePermissionTo($rolePermissions);
        }

        // Create admin user if it doesn't exist
        $admin = User::firstOrCreate([
            'email' => 'admin@test.com'
        ], [
            'name' => 'admin',
            'password' => bcrypt('123456admin')
        ]);

        // Assign role to admin user
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}