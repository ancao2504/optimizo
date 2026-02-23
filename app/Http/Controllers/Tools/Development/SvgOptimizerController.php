<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class SvgOptimizerController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'svg-optimizer')->first();
        return view('tools.development.svg-optimizer', compact('tool'));
    }
}
