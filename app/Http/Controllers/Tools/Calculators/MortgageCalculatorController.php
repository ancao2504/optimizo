<?php

namespace App\Http\Controllers\Tools\Calculators;

use App\Http\Controllers\Controller;
use App\Models\Tool;

class MortgageCalculatorController extends Controller
{
    public function index()
    {
        $tool = Tool::with(['categoryRelation'])->where('slug', 'mortgage-calculator')->active()->firstOrFail();
        return view('tools.calculators.mortgage-calculator', compact('tool'));
    }
}
