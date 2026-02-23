<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class CsvToYamlConverterController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'csv-to-yaml-converter')->first();
        return view('tools.development.csv-to-yaml-converter', compact('tool'));
    }
}
