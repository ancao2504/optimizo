<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;
use Illuminate\Support\Str;

class ImageMetadataViewerController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'image-metadata-viewer')->firstOrFail();
        return view("tools.image.image-metadata-viewer", compact('tool'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        // Use native exif_read_data if available, or just get basic info
        $data = [];

        // Basic Info
        $data['File Name'] = $file->getClientOriginalName();
        $data['File Size'] = $this->formatBytes($file->getSize());
        $data['MIME Type'] = $file->getMimeType();
        $dimensions = getimagesize($path);
        if ($dimensions) {
            $data['Width'] = $dimensions[0] . ' px';
            $data['Height'] = $dimensions[1] . ' px';
        }

        // EXIF Data
        if (function_exists('exif_read_data')) {
            try {
                // Suppress errors for files without EXIF
                $exif = @exif_read_data($path, 0, true);
                if ($exif) {
                    foreach ($exif as $key => $section) {
                        if (is_array($section)) {
                            foreach ($section as $name => $val) {
                                if (is_string($val) || is_numeric($val)) {
                                    // Filter overly long binary data
                                    if (strlen((string) $val) < 100) {
                                        $data["$key - $name"] = $val;
                                    }
                                }
                            }
                        } else {
                            if (is_string($section) || is_numeric($section)) {
                                $data[$key] = $section;
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                // Ignore
            }
        }

        return response()->json($data);
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
