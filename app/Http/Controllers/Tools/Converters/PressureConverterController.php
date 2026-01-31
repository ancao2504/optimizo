<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class PressureConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'pressure-converter')->active()->firstOrFail();
        return view("tools.converters.pressure-converter", compact('tool'));
    }
}