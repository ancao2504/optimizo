<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\Tool;

class JpgToHeicConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'jpg-to-heic-converter')->firstOrFail();
        return view("tools.image.jpg-to-heic-converter", compact('tool'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpeg,jpg|max:10240'
        ]);

        try {
            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = Str::slug($originalName) . '_' . Str::random(10) . '.heic';

            // Use storage public path
            $storagePath = storage_path('app/public/temp');
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            $inputPath = $file->getRealPath();
            $outputPath = $storagePath . '/' . $newFilename;

            // Execute magick command
            // magick input.jpg output.heic
            $command = ['magick', $inputPath, $outputPath];

            $process = new Process($command);
            $process->setTimeout(60);
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
