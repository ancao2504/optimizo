<?php

namespace App\Http\Controllers\Tools\Calculators;

use App\Http\Controllers\Controller;
use App\Models\Tool;

class AverageCalculatorController extends Controller
{
    public function index()
    {
        $tool = Tool::with(['categoryRelation'])->where('slug', 'average-calculator')->active()->firstOrFail();
        return view('tools.calculators.average-calculator', compact('tool'));
    }
}
