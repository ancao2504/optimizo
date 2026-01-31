<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class WeightConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'weight-converter')->active()->firstOrFail();
        return view("tools.converters.weight-converter", compact('tool'));
    }
}