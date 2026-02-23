<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class JavascriptObfuscatorController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'javascript-obfuscator')->first();
        return view('tools.development.javascript-obfuscator', compact('tool'));
    }
}
