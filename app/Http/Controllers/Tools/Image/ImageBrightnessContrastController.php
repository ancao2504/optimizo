<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class ImageBrightnessContrastController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'image-brightness-contrast-adjuster')->firstOrFail();
        return view("tools.image.image-brightness-contrast-adjuster", compact('tool'));
    }
}
