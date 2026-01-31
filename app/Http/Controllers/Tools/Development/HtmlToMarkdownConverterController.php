<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class HtmlToMarkdownConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'html-to-markdown-converter')->active()->firstOrFail();
        return view("tools.development.html-to-markdown-converter", compact('tool'));
    }
}