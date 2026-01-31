<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class EnergyConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'energy-converter')->active()->firstOrFail();
        return view("tools.converters.energy-converter", compact('tool'));
    }
}