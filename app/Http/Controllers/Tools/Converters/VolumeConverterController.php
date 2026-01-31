<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class VolumeConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'volume-converter')->active()->firstOrFail();
        return view("tools.converters.volume-converter", compact('tool'));
    }
}