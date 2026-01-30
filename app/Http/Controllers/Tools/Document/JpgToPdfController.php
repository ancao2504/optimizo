<?php

namespace App\Http\Controllers\Tools\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class JpgToPdfController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'jpg-to-pdf')->first();
        return view("tools.document.jpg-to-pdf", compact('tool'));
    }

    public function process(Request $request)
    {
        try {
            $request->validate(['file' => 'required|mimes:jpg,jpeg,png,webp|max:10240']);

            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $filename = Str::slug($originalName) . '_' . Str::random(10);
            $storagePath = storage_path('app/public/temp');

            // Ensure directory exists
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            // Save uploaded image temporarily to public path so DomPDF can read it (or use base64)
            // Using base64 is safer for DomPDF execution context.
            $imageData = base64_encode(file_get_contents($file->getPathname()));
            $src = 'data:image/' . $extension . ';base64,' . $imageData;

            // Create HTML with the image
            // Margin 0 to fit page
            $html = '<html><body style="margin:0;padding:0;"><img src="' . $src . '" style="width:100%;height:auto;"/></body></html>';

            // Generate PDF
            $pdf = Pdf::loadHTML($html);

            // Get dimensions to determine orientation
            list($width, $height) = getimagesize($file->getPathname());

            // Set paper size based on image aspect ratio
            if ($width > $height) {
                $pdf->setPaper('A4', 'landscape');
            } else {
                $pdf->setPaper('A4', 'portrait');
            }

            $pdfFilename = $filename . '.pdf';
            $pdf->save($storagePath . '/' . $pdfFilename);

            return response()->json([
                'success' => true,
                'message' => __('Processing completed successfully.'),
                'download_url' => asset('storage/temp/' . $pdfFilename)
            ]);

        } catch (\Exception $e) {
            \Log::error('JPG to PDF conversion failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('Error processing file: ' . $e->getMessage())
            ], 500);
        }
    }
}
