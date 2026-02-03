<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class BmpToJpgConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'bmp-to-jpg-converter')->firstOrFail();
        return view("tools.image.bmp-to-jpg-converter", compact('tool'));
    }
}
