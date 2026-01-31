<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class MolarMassConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'molar-mass-converter')->active()->firstOrFail();
        return view("tools.converters.molar-mass-converter", compact('tool'));
    }
}