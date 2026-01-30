<?php

namespace App\Http\Controllers\Tools\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;

class PdfMergerController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'pdf-merger')->first();
        return view("tools.document.pdf-merger", compact('tool'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'files' => 'required',
            'files.*' => 'mimes:pdf|max:10240'
        ]);

        try {
            $files = $request->file('files');
            if (count($files) < 2) {
                return response()->json(['success' => false, 'message' => __('Please select at least 2 PDF files.')], 422);
            }

            $pdf = new Fpdi();

            foreach ($files as $file) {
                $pageCount = $pdf->setSourceFile($file->getPathname());
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $templateId = $pdf->importPage($pageNo);
                    $size = $pdf->getTemplateSize($templateId);
                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($templateId);
                }
            }

            $filename = 'merged_' . Str::random(10) . '.pdf';
            $storagePath = storage_path('app/public/temp/' . $filename);

            // Ensure directory exists
            if (!file_exists(dirname($storagePath))) {
                mkdir(dirname($storagePath), 0755, true);
            }

            $pdf->Output('F', $storagePath);

            return response()->json([
                'success' => true,
                'message' => __('Merging completed successfully.'),
                'download_url' => asset('storage/temp/' . $filename)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error processing files: ' . $e->getMessage())
            ], 500);
        }
    }
}
