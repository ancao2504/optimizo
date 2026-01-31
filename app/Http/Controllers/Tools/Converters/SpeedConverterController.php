<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class SpeedConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'speed-converter')->active()->firstOrFail();
        return view("tools.converters.speed-converter", compact('tool'));
    }
}