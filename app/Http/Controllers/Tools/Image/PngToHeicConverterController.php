<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\Tool;

class PngToHeicConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'png-to-heic-converter')->firstOrFail();
        return view("tools.image.png-to-heic-converter", compact('tool'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:png|max:10240'
        ]);

        try {
            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = Str::slug($originalName) . '_' . Str::random(10) . '.heic';

            $storagePath = storage_path('app/public/temp');
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            $inputPath = $file->getRealPath();
            $outputPath = $storagePath . '/' . $newFilename;

            // Determine which command to use
            $binary = 'magick';

            // Check if magick exists and is runnable
            $processCheck = new Process(['magick', '-version']);
            $processCheck->run();

            if (!$processCheck->isSuccessful()) {
                $binary = 'convert';
            }

            // Execute magick/convert command
            // magick input.png output.heic
            $command = [$binary, $inputPath, $outputPath];

            $process = new Process($command);
            $process->setTimeout(60);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            if (!file_exists($outputPath) || filesize($outputPath) === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Conversion failed: Output file not created or empty.'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Image converted successfully.',
                'download_url' => asset('storage/temp/' . $newFilename)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error converting image: ' . $e->getMessage()
            ], 500);
        }
    }
}
