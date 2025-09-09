<?php

namespace Database\Seeders;

use App\Domains\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User permissions
            ['name' => 'users.view', 'display_name' => 'View Users', 'description' => 'Can view user list and details', 'group' => 'users'],
            ['name' => 'users.create', 'display_name' => 'Create Users', 'description' => 'Can create new users', 'group' => 'users'],
            ['name' => 'users.edit', 'display_name' => 'Edit Users', 'description' => 'Can edit existing users', 'group' => 'users'],
            ['name' => 'users.delete', 'display_name' => 'Delete Users', 'description' => 'Can delete users', 'group' => 'users'],
            
            // Role permissions
            ['name' => 'roles.view', 'display_name' => 'View Roles', 'description' => 'Can view role list and details', 'group' => 'roles'],
            ['name' => 'roles.create', 'display_name' => 'Create Roles', 'description' => 'Can create new roles', 'group' => 'roles'],
            ['name' => 'roles.edit', 'display_name' => 'Edit Roles', 'description' => 'Can edit existing roles', 'group' => 'roles'],
            ['name' => 'roles.delete', 'display_name' => 'Delete Roles', 'description' => 'Can delete roles', 'group' => 'roles'],
            
            // Permission permissions
            ['name' => 'permissions.view', 'display_name' => 'View Permissions', 'description' => 'Can view permission list', 'group' => 'permissions'],
            ['name' => 'permissions.manage', 'display_name' => 'Manage Permissions', 'description' => 'Can assign/remove permissions from roles', 'group' => 'permissions'],
            
            // System permissions
            ['name' => 'system.settings', 'display_name' => 'System Settings', 'description' => 'Can access system settings', 'group' => 'system'],
            ['name' => 'system.logs', 'display_name' => 'View Logs', 'description' => 'Can view system logs', 'group' => 'system'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
