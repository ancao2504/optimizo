<?php

namespace App\Http\Controllers\Tools\Calculators;

use App\Http\Controllers\Controller;
use App\Models\Tool;

class GpaCalculatorController extends Controller
{
    public function index()
    {
        $tool = Tool::with(['categoryRelation'])->where('slug', 'gpa-calculator')->active()->firstOrFail();
        return view('tools.calculators.gpa-calculator', compact('tool'));
    }
}
