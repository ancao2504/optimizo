<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class MigrateUsersToRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Get all roles
        $superAdminRole = Role::where('slug', 'super_admin')->first();
        $adminRole = Role::where('slug', 'admin')->first();
        $userRole = Role::where('slug', 'user')->first();

        // Migrate existing users to new role system
        User::chunk(100, function ($users) use ($superAdminRole, $adminRole, $userRole) {
            foreach ($users as $user) {
                // Skip if already migrated
                if ($user->role_id) {
                    continue;
                }

                // Map old role string to new role ID
                switch ($user->role) {
                    case 'super_admin':
                        $user->role_id = $superAdminRole->id;
                        break;
                    case 'admin':
                        $user->role_id = $adminRole->id;
                        break;
                    case 'user':
                    default:
                        $user->role_id = $userRole->id;
                        break;
                }

                $user->save();
            }
        });

        $this->command->info('Users migrated to new role system successfully!');
    }
}
