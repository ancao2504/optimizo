<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class WebPToPngConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'webp-to-png-converter')->firstOrFail();
        return view("tools.image.webp-to-png-converter", compact('tool'));
    }
}
