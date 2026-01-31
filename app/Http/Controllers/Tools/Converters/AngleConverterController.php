<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class AngleConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'angle-converter')->active()->firstOrFail();
        return view("tools.converters.angle-converter", compact('tool'));
    }
}