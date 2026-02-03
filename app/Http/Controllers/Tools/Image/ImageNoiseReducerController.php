<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class ImageNoiseReducerController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'image-noise-reducer')->firstOrFail();
        return view("tools.image.image-noise-reducer", compact('tool'));
    }
}
