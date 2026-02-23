<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;

class SqlFormatterController extends Controller
{
    public function index()
    {
        $tool = \App\Models\Tool::where('slug', 'sql-formatter')->first();
        return view('tools.development.sql-formatter', compact('tool'));
    }
}
