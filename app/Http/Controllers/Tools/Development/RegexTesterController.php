<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class RegexTesterController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'regex-tester')->first();
        return view('tools.development.regex-tester', compact('tool'));
    }
}
