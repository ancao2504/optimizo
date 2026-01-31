<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Get roles
        $superAdmin = Role::where('slug', 'super_admin')->first();
        $admin = Role::where('slug', 'admin')->first();
        $user = Role::where('slug', 'user')->first();

        // Super Admin gets all permissions
        $allPermissions = Permission::all()->pluck('id')->toArray();
        $superAdmin->syncPermissions($allPermissions);

        // Admin permissions
        $adminPermissions = Permission::whereIn('slug', [
            'view_users',
            'manage_content',
            'create_posts',
            'edit_posts',
            'delete_posts',
            'manage_categories',
            'manage_media',
            'view_settings',
            'manage_tools',
        ])->pluck('id')->toArray();
        $admin->syncPermissions($adminPermissions);

        // User permissions (basic access only)
        $userPermissions = Permission::whereIn('slug', [
            // Users have no special permissions by default
        ])->pluck('id')->toArray();
        $user->syncPermissions($userPermissions);
    }
}
