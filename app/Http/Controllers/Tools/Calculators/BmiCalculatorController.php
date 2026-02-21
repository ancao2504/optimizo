<?php

namespace App\Http\Controllers\Tools\Calculators;

use App\Http\Controllers\Controller;
use App\Models\Tool;

class BmiCalculatorController extends Controller
{
    public function index()
    {
        $tool = Tool::with(['categoryRelation'])->where('slug', 'bmi-calculator')->active()->firstOrFail();
        return view('tools.calculators.bmi-calculator', compact('tool'));
    }
}
