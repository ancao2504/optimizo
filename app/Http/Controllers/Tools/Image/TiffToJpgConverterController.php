<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\Tool;

class TiffToJpgConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'tiff-to-jpg-converter')->firstOrFail();
        return view("tools.image.tiff-to-jpg-converter", compact('tool'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:tiff,tif|max:51200' // Increased limit for TIFFs
        ]);

        try {
            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = Str::slug($originalName) . '_' . Str::random(10) . '.jpg';

            $storagePath = storage_path('app/public/temp');
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            $inputPath = $file->getRealPath();
            $outputPath = $storagePath . '/' . $newFilename;

            // magick input.tiff output.jpg
            $command = ['magick', $inputPath, $outputPath];

            $process = new Process($command);
            $process->setTimeout(120); // Longer timeout for large TIFFs
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
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
