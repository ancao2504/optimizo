<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\Tool;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ImageMetadataRemoverController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'image-metadata-remover')->firstOrFail();
        return view("tools.image.image-metadata-remover", compact('tool'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $inputPath = $file->getRealPath();

        $filename = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        // Output filename
        $newFilename = $filename . '_clean.' . $extension;
        $storagePath = storage_path('app/public/temp');
        $outputPath = $storagePath . '/' . $newFilename;

        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        // Use ImageMagick 'magick' command with '-strip' to remove all profiles and comments
        $command = ['magick', $inputPath, '-strip', $outputPath];

        $process = new Process($command);
        $process->setTimeout(60);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json([
            'download_url' => asset('storage/temp/' . $newFilename),
            'filename' => $newFilename
        ]);
    }
}
