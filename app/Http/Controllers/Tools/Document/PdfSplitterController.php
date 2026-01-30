<?php

namespace App\Http\Controllers\Tools\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;
use ZipArchive;

class PdfSplitterController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'pdf-splitter')->first();
        return view("tools.document.pdf-splitter", compact('tool'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240',
            'split_mode' => 'required|in:all,ranges',
            'range' => 'nullable|string'
        ]);

        try {
            $file = $request->file('file');
            $splitMode = $request->input('split_mode');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($file->getPathname());

            $pagesToExtract = [];

            if ($splitMode === 'all') {
                $pagesToExtract = range(1, $pageCount);
            } else {
                // Parse Range
                $rangeInput = $request->input('range');
                if (!$rangeInput) {
                    return response()->json(['success' => false, 'message' => __('Please specify a page range.')], 422);
                }

                $parts = explode(',', $rangeInput);
                foreach ($parts as $part) {
                    $part = trim($part);
                    if (strpos($part, '-') !== false) {
                        [$start, $end] = explode('-', $part);
                        $start = (int) $start;
                        $end = (int) $end;
                        if ($start > 0 && $end >= $start && $end <= $pageCount) {
                            $pagesToExtract = array_merge($pagesToExtract, range($start, $end));
                        }
                    } else {
                        $page = (int) $part;
                        if ($page > 0 && $page <= $pageCount) {
                            $pagesToExtract[] = $page;
                        }
                    }
                }
                $pagesToExtract = array_unique($pagesToExtract);
                sort($pagesToExtract);

                if (empty($pagesToExtract)) {
                    return response()->json(['success' => false, 'message' => __('Invalid page range.')], 422);
                }
            }

            // Create output content
            $tempDir = storage_path('app/public/temp/' . Str::random(10));
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // Generate single PDF if only 1 page or specific behavior? 
            // Usually split 'all' implies zip of single pages. 
            // Split 'range' implies 1 PDF containing those pages? Or separate PDFs?
            // "Split PDF" usually means "Extract Pages". 
            // If extracting a continuous range, usually 1 PDF.
            // If extracting "all", usually N PDFs.
            // Let's implement: 'all' -> ZIP of N files. 'ranges' -> 1 PDF with selected pages.

            if ($splitMode === 'ranges') {
                $newPdf = new Fpdi();
                $newPdf->setSourceFile($file->getPathname());
                foreach ($pagesToExtract as $pageNo) {
                    $templateId = $newPdf->importPage($pageNo);
                    $size = $newPdf->getTemplateSize($templateId);
                    $newPdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $newPdf->useTemplate($templateId);
                }

                $filename = $originalName . '_split.pdf';
                $outputPath = $tempDir . '/' . $filename;
                $newPdf->Output('F', $outputPath);

                // Move to public temp for download (or just use tempDir if inside public/temp)
                // $tempDir is inside storage/app/public/temp/... 
                // We should move file up or return path inside subdir.

                $downloadUrl = asset('storage/temp/' . basename($tempDir) . '/' . $filename);

            } else {
                // Split ALL pages into separate files and ZIP them
                $zip = new ZipArchive();
                $zipName = $originalName . '_split.zip';
                $zipPath = $tempDir . '/' . $zipName;

                if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
                    throw new \Exception("Cannot open <$zipPath>");
                }

                foreach ($pagesToExtract as $pageNo) {
                    $newPdf = new Fpdi();
                    $newPdf->setSourceFile($file->getPathname());
                    $templateId = $newPdf->importPage($pageNo);
                    $size = $newPdf->getTemplateSize($templateId);
                    $newPdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $newPdf->useTemplate($templateId);

                    $pageFilename = $originalName . '_page_' . $pageNo . '.pdf';
                    $pagePath = $tempDir . '/' . $pageFilename;
                    $newPdf->Output('F', $pagePath);

                    $zip->addFile($pagePath, $pageFilename);
                }
                $zip->close();

                $downloadUrl = asset('storage/temp/' . basename($tempDir) . '/' . $zipName);
            }

            return response()->json([
                'success' => true,
                'message' => __('Processing completed successfully.'),
                'download_url' => $downloadUrl
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error processing file: ' . $e->getMessage())
            ], 500);
        }
    }
}
