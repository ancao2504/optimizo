<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class LengthConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'length-converter')->active()->firstOrFail();
        return view("tools.converters.length-converter", compact('tool'));
    }
}