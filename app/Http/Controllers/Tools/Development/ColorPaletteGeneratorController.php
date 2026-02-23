<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class ColorPaletteGeneratorController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'color-palette-generator')->first();
        return view('tools.development.color-palette-generator', compact('tool'));
    }
}
