<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class ImageSharpenerController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'image-sharpener')->firstOrFail();
        return view("tools.image.image-sharpener", compact('tool'));
    }
}
