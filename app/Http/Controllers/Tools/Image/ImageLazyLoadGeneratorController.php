<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class ImageLazyLoadGeneratorController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'image-lazy-load-generator')->firstOrFail();
        return view("tools.image.image-lazy-load-generator", compact('tool'));
    }
}
