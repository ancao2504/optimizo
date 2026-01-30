<?php

namespace App\Http\Controllers\Tools\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Str;

class PdfToExcelController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'pdf-to-excel')->first();
        return view("tools.document.pdf-to-excel", compact('tool'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240'
        ]);

        try {
            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            // Parse PDF
            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $text = $pdf->getText();

            // Create Spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Basic text parsing: split by new lines
            $lines = explode("\n", $text);
            $row = 1;

            foreach ($lines as $line) {
                // Try to detect columns by tabs or multiple spaces
                // This is a heuristic approach and won't be perfect
                $columns = preg_split('/\t+|\s{2,}/', trim($line));

                if (!empty($columns)) {
                    $col = 1;
                    foreach ($columns as $cellData) {
                        $sheet->setCellValueExplicit(
                            [$col, $row],
                            $cellData,
                            \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
                        );
                        $col++;
                    }
                    $row++;
                }
            }

            $filename = Str::slug($originalName) . '_' . Str::random(10) . '.xlsx';
            $storagePath = storage_path('app/public/temp/' . $filename);

            // Ensure directory exists
            if (!file_exists(dirname($storagePath))) {
                mkdir(dirname($storagePath), 0755, true);
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save($storagePath);

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
