<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tool;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class FixToolCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tool:fix-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix tool categories on production based on language file structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting category fix...');

        $langPath = resource_path('lang/en/tools');

        if (!File::exists($langPath)) {
            $this->error("Language directory not found at: $langPath");
            return 1;
        }

        $files = File::files($langPath);
        $updatedTools = 0;

        foreach ($files as $file) {
            $filename = $file->getFilename();
            // Skip non-json files or directories
            if ($file->getExtension() !== 'json')
                continue;

            $categorySlug = pathinfo($filename, PATHINFO_FILENAME);

            // 1. Ensure Category Exists
            $category = Category::firstOrCreate(
                ['slug' => $categorySlug],
                [
                    'name' => ucwords(str_replace('-', ' ', $categorySlug)),
                    'is_active' => true,
                    // Default styling if creating new
                    'bg_gradient_from' => '#6366f1',
                    'bg_gradient_to' => '#4f46e5',
                    'text_color' => 'text-indigo-600'
                ]
            );

            $this->info("Processing Category: $categorySlug (ID: {$category->id})");

            $content = json_decode(file_get_contents($file->getPathname()), true);

            if (!$content) {
                continue;
            }

            foreach ($content as $toolSlug => $data) {
                // 2. Find tool and update category_id
                $tool = Tool::where('slug', $toolSlug)->first();

                if ($tool) {
                    if ($tool->category_id !== $category->id) {
                        $tool->category_id = $category->id;
                        $tool->save();
                        $updatedTools++;
                        $this->line("   - Fixed: $toolSlug");
                    }
                }
            }
        }

        $this->info("Success! Fixed categories for $updatedTools tools.");
        $this->info("You can now run 'php artisan cache:clear' to ensure updates are reflected immediately.");
    }
}
