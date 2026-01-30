<?php

namespace App\Http\Controllers\Tools\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Str;

class WordToPdfController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'word-to-pdf')->first();
        return view("tools.document.word-to-pdf", compact('tool'));
    }

    public function process(Request $request)
    {
        $request->validate(['file' => 'required|mimes:doc,docx|max:10240']);

        try {
            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            // Set PDF Renderer
            $rendererName = Settings::PDF_RENDERER_DOMPDF;
            $rendererLibraryPath = base_path('vendor/dompdf/dompdf');

            // Validate renderer path logic inside PHPWord usually checks for file existence
            if (!Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                throw new \Exception(__('PDF Renderer configuration failed.'));
            }

            // Load Word File
            $phpWord = IOFactory::load($file->getPathname());

            $filename = Str::slug($originalName) . '_' . Str::random(10) . '.pdf';
            $storagePath = storage_path('app/public/temp/' . $filename);

            // Ensure directory exists
            if (!file_exists(dirname($storagePath))) {
                mkdir(dirname($storagePath), 0755, true);
            }

            // Save as PDF
            $objWriter = IOFactory::createWriter($phpWord, 'PDF');
            $objWriter->save($storagePath);

            return response()->json([
                'success' => true,
                'message' => __('Processing completed successfully.'),
                'download_url' => asset('storage/temp/' . $filename)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error processing file: ' . $e->getMessage())
            ], 500);
        }
    }
}