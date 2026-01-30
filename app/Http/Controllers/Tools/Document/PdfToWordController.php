<?php

namespace App\Http\Controllers\Tools\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Str;

class PdfToWordController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'pdf-to-word')->first();
        return view("tools.document.pdf-to-word", compact('tool'));
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

            // Create Word Document
            $phpWord = new PhpWord();
            $section = $phpWord->addSection();

            // Split text by new lines to maintain some structure
            $lines = explode("\n", $text);
            foreach ($lines as $line) {
                // Sanitize line ??
                $section->addText($line);
            }

            $filename = Str::slug($originalName) . '_' . Str::random(10) . '.docx';
            $storagePath = storage_path('app/public/temp/' . $filename);

            // Ensure directory exists
            if (!file_exists(dirname($storagePath))) {
                mkdir(dirname($storagePath), 0755, true);
            }

            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
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
