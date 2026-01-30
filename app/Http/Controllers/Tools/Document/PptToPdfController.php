<?php

namespace App\Http\Controllers\Tools\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


class PptToPdfController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'ppt-to-pdf')->first();
        return view("tools.document.ppt-to-pdf", compact('tool'));
    }

    public function process(Request $request)
    {
        $request->validate(['file' => 'required|mimes:ppt,pptx|max:10240']);

        return response()->json([
            'success' => false,
            'message' => __('This tool is currently unavailable as it requires specific PHP extensions for PowerPoint conversion.')
        ], 503);
    }
}
