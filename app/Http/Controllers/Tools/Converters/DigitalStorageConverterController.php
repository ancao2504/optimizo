<?php

namespace App\Http\Controllers\Tools\Converters;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class DigitalStorageConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'digital-storage-converter')->active()->firstOrFail();
        return view("tools.converters.digital-storage-converter", compact('tool'));
    }
}