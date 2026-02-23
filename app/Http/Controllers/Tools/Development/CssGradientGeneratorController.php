<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class CssGradientGeneratorController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'css-gradient-generator')->first();
        return view('tools.development.css-gradient-generator', compact('tool'));
    }
}
