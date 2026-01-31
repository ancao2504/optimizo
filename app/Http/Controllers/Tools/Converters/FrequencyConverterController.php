<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class FrequencyConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'frequency-converter')->active()->firstOrFail();
        return view("tools.converters.frequency-converter", compact('tool'));
    }
}