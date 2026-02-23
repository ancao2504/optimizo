<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class JsonValidatorController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'json-validator')->first();
        return view('tools.development.json-validator', compact('tool'));
    }
}
