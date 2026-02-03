<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class GrayscaleImageConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'grayscale-image-converter')->firstOrFail();
        return view("tools.image.grayscale-image-converter", compact('tool'));
    }
}
