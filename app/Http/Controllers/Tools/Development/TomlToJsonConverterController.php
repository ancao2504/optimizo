<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class TomlToJsonConverterController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'toml-to-json-converter')->first();
        return view('tools.development.toml-to-json-converter', compact('tool'));
    }
}
