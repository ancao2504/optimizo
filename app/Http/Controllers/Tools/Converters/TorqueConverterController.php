<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class TorqueConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'torque-converter')->active()->firstOrFail();
        return view("tools.converters.torque-converter", compact('tool'));
    }
}