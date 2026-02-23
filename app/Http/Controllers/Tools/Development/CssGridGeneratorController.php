<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class CssGridGeneratorController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'css-grid-generator')->first();
        return view('tools.development.css-grid-generator', compact('tool'));
    }
}
