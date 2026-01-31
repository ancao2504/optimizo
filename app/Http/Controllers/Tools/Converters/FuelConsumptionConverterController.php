<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class FuelConsumptionConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'fuel-consumption-converter')->active()->firstOrFail();
        return view("tools.converters.fuel-consumption-converter", compact('tool'));
    }
}