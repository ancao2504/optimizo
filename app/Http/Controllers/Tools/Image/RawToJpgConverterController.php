<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\Tool;

class RawToJpgConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'raw-to-jpg-converter')->firstOrFail();
        return view("tools.image.raw-to-jpg-converter", compact('tool'));
    }

    public function process(Request $request)
    {
        // 50MB Max size for RAW files
        $request->validate([
            'file' => 'required|max:51200'
        ]);

        try {
            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = strtolower($file->getClientOriginalExtension());

            // Basic validation for common RAW extensions
            $allowedExtensions = ['cr2', 'nef', 'arw', 'dng', 'orf', 'rw2', 'pef', 'sr2', 'raf'];
            if (!in_array($extension, $allowedExtensions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unsupported RAW format. Please upload CR2, NEF, ARW, DNG, or similar.'
                ], 422);
            }

            $newFilename = Str::slug($originalName) . '_' . Str::random(10) . '.jpg';

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

            // magick input.raw output.jpg
            $command = [$binary, $inputPath, $outputPath];

            $process = new Process($command);
            $process->setTimeout(180); // 3 minutes timeout
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
