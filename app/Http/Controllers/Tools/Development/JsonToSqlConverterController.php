<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class JsonToSqlConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'json-to-sql-converter')->active()->firstOrFail();
        return view("tools.development.json-to-sql-converter", compact('tool'));
    }
}