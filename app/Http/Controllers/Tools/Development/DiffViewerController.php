<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class DiffViewerController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'diff-viewer')->first();
        return view('tools.development.diff-viewer', compact('tool'));
    }
}
