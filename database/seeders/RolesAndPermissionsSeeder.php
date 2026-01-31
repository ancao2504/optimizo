<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     * This seeder creates all roles, permissions, and assigns permissions to roles.
     */
    public function run(): void
    {
        // Create Permissions
        $permissions = $this->createPermissions();

        // Create Roles
        $roles = $this->createRoles();

        // Assign Permissions to Roles
        $this->assignPermissionsToRoles($roles, $permissions);

        $this->command->info('Roles and permissions seeded successfully!');
    }

    /**
     * Create all permissions.
     */
    private function createPermissions(): array
    {
        $permissionsData = [
            // User Management
            ['name' => 'Manage Users', 'slug' => 'manage_users', 'description' => 'Create, edit, and delete users', 'category' => 'User Management'],
            ['name' => 'View Users', 'slug' => 'view_users', 'description' => 'View user list and details', 'category' => 'User Management'],
            ['name' => 'Create Users', 'slug' => 'create_users', 'description' => 'Create new users', 'category' => 'User Management'],
            ['name' => 'Edit Users', 'slug' => 'edit_users', 'description' => 'Edit existing users', 'category' => 'User Management'],
            ['name' => 'Delete Users', 'slug' => 'delete_users', 'description' => 'Delete users', 'category' => 'User Management'],
            ['name' => 'Manage Roles', 'slug' => 'manage_roles', 'description' => 'Create, edit, and delete roles', 'category' => 'User Management'],
            ['name' => 'Manage Permissions', 'slug' => 'manage_permissions', 'description' => 'Create, edit, and delete permissions', 'category' => 'User Management'],

            // Content Management
            ['name' => 'Manage Content', 'slug' => 'manage_content', 'description' => 'Full access to content management', 'category' => 'Content Management'],
            ['name' => 'Create Posts', 'slug' => 'create_posts', 'description' => 'Create new blog posts', 'category' => 'Content Management'],
            ['name' => 'Edit Posts', 'slug' => 'edit_posts', 'description' => 'Edit existing blog posts', 'category' => 'Content Management'],
            ['name' => 'Delete Posts', 'slug' => 'delete_posts', 'description' => 'Delete blog posts', 'category' => 'Content Management'],
            ['name' => 'Publish Posts', 'slug' => 'publish_posts', 'description' => 'Publish blog posts', 'category' => 'Content Management'],
            ['name' => 'Manage Categories', 'slug' => 'manage_categories', 'description' => 'Manage blog categories', 'category' => 'Content Management'],
            ['name' => 'Manage Media', 'slug' => 'manage_media', 'description' => 'Upload and manage media files', 'category' => 'Content Management'],

            // Settings
            ['name' => 'Manage Settings', 'slug' => 'manage_settings', 'description' => 'Access and modify system settings', 'category' => 'Settings'],
            ['name' => 'View Settings', 'slug' => 'view_settings', 'description' => 'View system settings', 'category' => 'Settings'],

            // Tools
            ['name' => 'Manage Tools', 'slug' => 'manage_tools', 'description' => 'Manage tool configurations', 'category' => 'Tools'],
            ['name' => 'Access Premium Tools', 'slug' => 'access_premium_tools', 'description' => 'Access to premium/pro tools', 'category' => 'Tools'],
            ['name' => 'Unlimited Conversions', 'slug' => 'unlimited_conversions', 'description' => 'No limits on tool conversions', 'category' => 'Tools'],

            // Admin Panel
            ['name' => 'Access Admin Panel', 'slug' => 'access_admin_panel', 'description' => 'Access to admin panel', 'category' => 'Admin'],
            ['name' => 'View Dashboard', 'slug' => 'view_dashboard', 'description' => 'View admin dashboard', 'category' => 'Admin'],
        ];

        $permissions = [];
        foreach ($permissionsData as $permData) {
            $permissions[$permData['slug']] = Permission::firstOrCreate(
                ['slug' => $permData['slug']],
                $permData
            );
        }

        return $permissions;
    }

    /**
     * Create all roles.
     */
    private function createRoles(): array
    {
        $rolesData = [
            [
                'name' => 'Super Administrator',
                'slug' => 'super_admin',
                'description' => 'Full system access with all permissions',
                'is_system_role' => true,
            ],
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Content and settings management access',
                'is_system_role' => true,
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => 'Basic user access',
                'is_system_role' => true,
            ],
        ];

        $roles = [];
        foreach ($rolesData as $roleData) {
            $roles[$roleData['slug']] = Role::firstOrCreate(
                ['slug' => $roleData['slug']],
                $roleData
            );
        }

        return $roles;
    }

    /**
     * Assign permissions to roles.
     */
    private function assignPermissionsToRoles(array $roles, array $permissions): void
    {
        // Super Admin - All permissions
        $allPermissionIds = array_map(fn($p) => $p->id, $permissions);
        $roles['super_admin']->syncPermissions($allPermissionIds);

        // Admin - Content management, view users, settings, tools
        $adminPermissions = [
            $permissions['access_admin_panel']->id,
            $permissions['view_dashboard']->id,
            $permissions['view_users']->id,
            $permissions['manage_content']->id,
            $permissions['create_posts']->id,
            $permissions['edit_posts']->id,
            $permissions['delete_posts']->id,
            $permissions['publish_posts']->id,
            $permissions['manage_categories']->id,
            $permissions['manage_media']->id,
            $permissions['view_settings']->id,
            $permissions['manage_tools']->id,
        ];
        $roles['admin']->syncPermissions($adminPermissions);

        // User - No special permissions (basic access only)
        $roles['user']->syncPermissions([]);
    }
}
