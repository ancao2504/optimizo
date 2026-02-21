<?php

namespace App\Http\Controllers\Tools\Calculators;

use App\Http\Controllers\Controller;
use App\Models\Tool;

class PercentageCalculatorController extends Controller
{
    public function index()
    {
        $tool = Tool::with(['categoryRelation'])->where('slug', 'percentage-calculator')->active()->firstOrFail();
        return view('tools.calculators.percentage-calculator', compact('tool'));
    }
}
