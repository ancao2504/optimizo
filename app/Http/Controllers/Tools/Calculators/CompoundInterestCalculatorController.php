<?php

namespace App\Http\Controllers\Tools\Calculators;

use App\Http\Controllers\Controller;
use App\Models\Tool;

class CompoundInterestCalculatorController extends Controller
{
    public function index()
    {
        $tool = Tool::with(['categoryRelation'])->where('slug', 'compound-interest-calculator')->active()->firstOrFail();
        return view('tools.calculators.compound-interest-calculator', compact('tool'));
    }
}
