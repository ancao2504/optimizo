<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class HtmlToJsxConverterController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'html-to-jsx-converter')->first();
        return view('tools.development.html-to-jsx-converter', compact('tool'));
    }
}
