<?php

namespace App\Http\Controllers\Tools\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Html;

class ExcelToPdfController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'excel-to-pdf')->first();
        return view("tools.document.excel-to-pdf", compact('tool'));
    }

    public function process(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xls,xlsx|max:10240']);

        try {
            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $filename = Str::slug($originalName) . '_' . Str::random(10) . '.pdf';
            $storagePath = storage_path('app/public/temp/' . $filename);

            // Ensure directory exists
            if (!file_exists(dirname($storagePath))) {
                mkdir(dirname($storagePath), 0755, true);
            }

            // Load the Excel file
            $spreadsheet = IOFactory::load($file->getPathname());

            // Convert to HTML
            $writer = new Html($spreadsheet);
            // $writer->setUseInlineCss(true); // Optional: improves styling
            $htmlContent = $writer->generateHTMLAll();

            // Generate PDF from HTML
            $pdf = Pdf::loadHTML($htmlContent);
            $pdf->setPaper('A4', 'landscape'); // Spreadsheet usually looks better in landscape

            $pdf->save($storagePath);

            return response()->json([
                'success' => true,
                'message' => __('Processing completed successfully.'),
                'download_url' => asset('storage/temp/' . $filename)
            ]);

        } catch (\Exception $e) {
            \Log::error('Excel to PDF conversion failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('Error processing file: ' . $e->getMessage())
            ], 500);
        }
    }
}
