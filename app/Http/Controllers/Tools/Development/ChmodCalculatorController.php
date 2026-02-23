<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class ChmodCalculatorController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'chmod-calculator')->first();
        return view('tools.development.chmod-calculator', compact('tool'));
    }
}
