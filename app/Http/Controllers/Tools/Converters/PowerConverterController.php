<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class PowerConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'power-converter')->active()->firstOrFail();
        return view("tools.converters.power-converter", compact('tool'));
    }
}