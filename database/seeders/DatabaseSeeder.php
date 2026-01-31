<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class, // Seed roles, permissions, and assignments
            PlansTableSeeder::class, // Seed subscription plans
            \Database\Seeders\LanguageSeeder::class,
            AdminUserSeeder::class, // Create admin users (requires roles to exist first)
                // CategorySeeder::class, // Temporarily disabled - has column mismatch issue
            ToolSeeder::class,
        ]);
    }
}
