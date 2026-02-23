<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class YamlFormatterController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'yaml-formatter')->first();
        return view('tools.development.yaml-formatter', compact('tool'));
    }
}
