<?php

namespace App\Http\Controllers\Tools\Calculators;

use App\Http\Controllers\Controller;
use App\Models\Tool;

class DiscountCalculatorController extends Controller
{
    public function index()
    {
        $tool = Tool::with(['categoryRelation'])->where('slug', 'discount-calculator')->active()->firstOrFail();
        return view('tools.calculators.discount-calculator', compact('tool'));
    }
}
