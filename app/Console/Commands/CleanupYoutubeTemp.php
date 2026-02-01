<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CleanupYoutubeTemp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:youtube-temp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup temporary YouTube download files older than 60 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = storage_path('app/public/temp/youtube');

        if (!File::exists($path)) {
            $this->info('Directory does not exist: ' . $path);
            return;
        }

        $files = File::files($path);
        // Expiration time: 60 minutes ago
        $expiresAt = now()->subMinutes(60)->timestamp;

        $count = 0;

        foreach ($files as $file) {
            // Check if file is older than 60 minutes
            if ($file->getMTime() < $expiresAt) {
                File::delete($file->getPathname());
                $count++;
            }
        }

        $this->info("Cleaned up {$count} files from {$path}");
    }
}
