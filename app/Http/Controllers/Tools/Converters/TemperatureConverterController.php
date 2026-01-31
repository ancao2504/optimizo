<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class TemperatureConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'temperature-converter')->active()->firstOrFail();
        return view("tools.converters.temperature-converter", compact('tool'));
    }
}