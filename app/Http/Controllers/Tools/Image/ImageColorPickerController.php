<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class ImageColorPickerController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'image-color-picker')->firstOrFail();
        return view("tools.image.image-color-picker", compact('tool'));
    }
}
