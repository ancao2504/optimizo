<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class AreaConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'area-converter')->active()->firstOrFail();
        return view("tools.converters.area-converter", compact('tool'));
    }
}