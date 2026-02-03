<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class AvifToPngConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'avif-to-png-converter')->firstOrFail();
        return view("tools.image.avif-to-png-converter", compact('tool'));
    }
}
