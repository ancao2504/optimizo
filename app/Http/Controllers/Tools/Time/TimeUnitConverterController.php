<?php

namespace App\Http\Controllers\Tools\Time;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class TimeUnitConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'time-unit-converter')->active()->firstOrFail();
        return view("tools.time.time-unit-converter", compact('tool'));
    }
}