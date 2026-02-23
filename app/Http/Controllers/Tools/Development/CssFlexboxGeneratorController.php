<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class CssFlexboxGeneratorController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'css-flexbox-generator')->first();
        return view('tools.development.css-flexbox-generator', compact('tool'));
    }
}
