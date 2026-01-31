<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tool;
// use App\Services\ToolData; // Removed

class ToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeding logic removed as ToolData service is deprecated.
        // Tools are now managed directly in the database.
        // If you need to seed initial tools, please restore from a database dump.
    }
}
