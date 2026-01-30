<?php

namespace App\Http\Controllers\Tools\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


class PdfToPptController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'pdf-to-ppt')->first();
        return view("tools.document.pdf-to-ppt", compact('tool'));
    }

    public function process(Request $request)
    {
        $request->validate(['file' => 'required|mimes:pdf|max:10240']);

        return response()->json([
            'success' => false,
            'message' => __('PDF to PowerPoint conversion is highly complex and currently not supported without external API services.')
        ], 503);
    }
}
