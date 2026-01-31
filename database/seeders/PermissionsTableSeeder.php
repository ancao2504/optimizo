<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // User Management
            [
                'name' => 'Manage Users',
                'slug' => 'manage_users',
                'description' => 'Create, edit, and delete users',
                'category' => 'User Management',
            ],
            [
                'name' => 'View Users',
                'slug' => 'view_users',
                'description' => 'View user list and details',
                'category' => 'User Management',
            ],
            [
                'name' => 'Manage Roles',
                'slug' => 'manage_roles',
                'description' => 'Create, edit, and delete roles',
                'category' => 'User Management',
            ],
            [
                'name' => 'Manage Permissions',
                'slug' => 'manage_permissions',
                'description' => 'Create, edit, and delete permissions',
                'category' => 'User Management',
            ],

            // Content Management
            [
                'name' => 'Manage Content',
                'slug' => 'manage_content',
                'description' => 'Full access to content management',
                'category' => 'Content Management',
            ],
            [
                'name' => 'Create Posts',
                'slug' => 'create_posts',
                'description' => 'Create new blog posts',
                'category' => 'Content Management',
            ],
            [
                'name' => 'Edit Posts',
                'slug' => 'edit_posts',
                'description' => 'Edit existing blog posts',
                'category' => 'Content Management',
            ],
            [
                'name' => 'Delete Posts',
                'slug' => 'delete_posts',
                'description' => 'Delete blog posts',
                'category' => 'Content Management',
            ],
            [
                'name' => 'Manage Categories',
                'slug' => 'manage_categories',
                'description' => 'Manage blog categories',
                'category' => 'Content Management',
            ],
            [
                'name' => 'Manage Media',
                'slug' => 'manage_media',
                'description' => 'Upload and manage media files',
                'category' => 'Content Management',
            ],

            // Settings
            [
                'name' => 'Manage Settings',
                'slug' => 'manage_settings',
                'description' => 'Access and modify system settings',
                'category' => 'Settings',
            ],
            [
                'name' => 'View Settings',
                'slug' => 'view_settings',
                'description' => 'View system settings',
                'category' => 'Settings',
            ],

            // Tools
            [
                'name' => 'Manage Tools',
                'slug' => 'manage_tools',
                'description' => 'Manage tool configurations',
                'category' => 'Tools',
            ],
            [
                'name' => 'Access Premium Tools',
                'slug' => 'access_premium_tools',
                'description' => 'Access to premium/pro tools',
                'category' => 'Tools',
            ],
            [
                'name' => 'Unlimited Conversions',
                'slug' => 'unlimited_conversions',
                'description' => 'No limits on tool conversions',
                'category' => 'Tools',
            ],
        ];

        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate(
                ['slug' => $permissionData['slug']],
                $permissionData
            );
        }
    }
}
