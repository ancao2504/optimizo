<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class JsonToTomlConverterController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'json-to-toml-converter')->first();
        return view('tools.development.json-to-toml-converter', compact('tool'));
    }
}
