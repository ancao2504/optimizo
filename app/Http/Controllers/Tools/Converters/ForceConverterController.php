<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class ForceConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'force-converter')->active()->firstOrFail();
        return view("tools.converters.force-converter", compact('tool'));
    }
}