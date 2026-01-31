<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tool;
use Illuminate\Support\Facades\File;

class CheckMissingIcons extends Command
{
    protected $signature = 'tool:check-icons';
    protected $description = 'Check for missing icon files for tools';

    public function handle()
    {
        $tools = Tool::all();
        $missing = [];
        $withIcons = 0;

        foreach ($tools as $tool) {
            if (empty($tool['icon_svg']) || trim($tool['icon_svg']) === '') {
                $missing[] = [
                    'name' => $tool['name'] ?? 'Unknown',
                    'slug' => $tool['slug'] ?? 'unknown',
                    'category' => $tool['category'] ?? 'unknown',
                ];
            } else {
                $withIcons++;
            }
        }

        $this->info("Tools with icons: {$withIcons}");
        $this->info("Tools missing icons: " . count($missing));

        if (!empty($missing)) {
            $this->newLine();
            $this->warn("Tools missing icon_svg:");
            foreach ($missing as $tool) {
                $this->line("  - {$tool['name']} ({$tool['slug']}) [{$tool['category']}]");
            }
        }

        return 0;
    }
}
