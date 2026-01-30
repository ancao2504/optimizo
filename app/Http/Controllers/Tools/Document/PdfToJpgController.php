<?php

namespace App\Http\Controllers\Tools\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


class PdfToJpgController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'pdf-to-jpg')->first();
        return view("tools.document.pdf-to-jpg", compact('tool'));
    }

    public function process(Request $request)
    {
        $request->validate(['file' => 'required|mimes:pdf|max:10240']);

        return response()->json([
            'success' => false,
            'message' => __('This tool requires server-side dependencies (Imagick and Ghostscript) which are not currently installed.')
        ], 503);
    }
}
