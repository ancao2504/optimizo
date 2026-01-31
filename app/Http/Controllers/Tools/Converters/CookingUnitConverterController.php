<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class CookingUnitConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'cooking-unit-converter')->active()->firstOrFail();
        return view("tools.converters.cooking-unit-converter", compact('tool'));
    }
}