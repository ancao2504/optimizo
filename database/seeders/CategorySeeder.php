<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
// use App\Services\ToolData; // Removed
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean up existing tool categories - REMOVED for production safety
        // Category::query()->delete();
        // \App\Models\BlogCategory::query()->delete();

        $categories = [
            'youtube' => [
                'from' => '#ef4444',
                'to' => '#b91c1c',
                'text' => 'text-red-600'
            ],
            'seo' => [
                'from' => '#10b981',
                'to' => '#047857',
                'text' => 'text-emerald-600'
            ],
            'utility' => [
                'from' => '#3b82f6',
                'to' => '#1d4ed8',
                'text' => 'text-blue-600'
            ]
        ];

        foreach ($categories as $slug => $colors) {
            Category::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => ucwords(str_replace('-', ' ', $slug)),
                    'bg_gradient_from' => $colors['from'],
                    'bg_gradient_to' => $colors['to'],
                    'text_color' => $colors['text']
                ]
            );
        }

        // Seed some sample Blog Categories
        /*
        \App\Models\BlogCategory::create([
            'name' => 'General News',
            'slug' => 'general-news',
            'description' => 'General announcements and news.'
        ]);
        \App\Models\BlogCategory::create([
            'name' => 'Tutorials',
            'slug' => 'tutorials',
            'description' => 'Detailed guides and how-tos.'
        ]);
        */
    }
}
