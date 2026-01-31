<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class DataTransferRateConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'data-transfer-rate-converter')->active()->firstOrFail();
        return view("tools.converters.data-transfer-rate-converter", compact('tool'));
    }
}