<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

// 1. Create the calculators category
$catExists = DB::table('categories')->where('slug', 'calculators')->exists();
if (!$catExists) {
    DB::table('categories')->insert([
        'name' => 'Calculators',
        'slug' => 'calculators',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "Created 'calculators' category\n";
} else {
    echo "Category 'calculators' already exists\n";
}

$categoryId = DB::table('categories')->where('slug', 'calculators')->value('id');
echo "Category ID: $categoryId\n";

// 2. Create the 8 tools
$tools = [
    ['name' => 'Percentage Calculator', 'slug' => 'percentage-calculator', 'icon_name' => 'calculator', 'order' => 1],
    ['name' => 'Scientific Calculator', 'slug' => 'scientific-calculator', 'icon_name' => 'calculator', 'order' => 2],
    ['name' => 'BMI Calculator', 'slug' => 'bmi-calculator', 'icon_name' => 'calculator', 'order' => 3],
    ['name' => 'Mortgage Calculator', 'slug' => 'mortgage-calculator', 'icon_name' => 'calculator', 'order' => 4],
    ['name' => 'Compound Interest Calculator', 'slug' => 'compound-interest-calculator', 'icon_name' => 'calculator', 'order' => 5],
    ['name' => 'GPA Calculator', 'slug' => 'gpa-calculator', 'icon_name' => 'calculator', 'order' => 6],
    ['name' => 'Discount Calculator', 'slug' => 'discount-calculator', 'icon_name' => 'calculator', 'order' => 7],
    ['name' => 'Average Calculator', 'slug' => 'average-calculator', 'icon_name' => 'calculator', 'order' => 8],
];

foreach ($tools as $tool) {
    $exists = DB::table('tools')->where('slug', $tool['slug'])->exists();
    if (!$exists) {
        DB::table('tools')->insert([
            'name' => $tool['name'],
            'slug' => $tool['slug'],
            'category_id' => $categoryId,
            'icon_name' => $tool['icon_name'],
            'controller' => 'App\\Http\\Controllers\\Tools\\Calculators\\' . str_replace(['-', ' '], '', ucwords($tool['name'], '- ')) . 'Controller',
            'route_name' => 'calculators.' . $tool['slug'],
            'url' => '/tools/' . $tool['slug'],
            'is_active' => 1,
            'order' => $tool['order'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "Created tool: {$tool['name']}\n";
    } else {
        echo "Tool already exists: {$tool['name']}\n";
    }
}

echo "\nDone! All tools created.\n";

// Print SQL for production
echo "\n=== SQL FOR PRODUCTION ===\n";
echo "INSERT INTO categories (name, slug, created_at, updated_at) VALUES ('Calculators', 'calculators', NOW(), NOW());\n\n";
echo "SET @cat_id = (SELECT id FROM categories WHERE slug = 'calculators');\n\n";
foreach ($tools as $tool) {
    $controller = 'App\\\\Http\\\\Controllers\\\\Tools\\\\Calculators\\\\' . str_replace(['-', ' '], '', ucwords($tool['name'], '- ')) . 'Controller';
    echo "INSERT INTO tools (name, slug, category_id, icon_name, controller, route_name, url, is_active, `order`, created_at, updated_at) VALUES ('{$tool['name']}', '{$tool['slug']}', @cat_id, '{$tool['icon_name']}', '$controller', 'calculators.{$tool['slug']}', '/tools/{$tool['slug']}', 1, {$tool['order']}, NOW(), NOW());\n";
}
