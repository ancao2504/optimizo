<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class ApiRequestBuilderController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'api-request-builder')->first();
        return view('tools.development.api-request-builder', compact('tool'));
    }
}
