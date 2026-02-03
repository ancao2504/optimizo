<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class ResponsiveImageGeneratorController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'responsive-image-generator')->firstOrFail();
        return view("tools.image.responsive-image-generator", compact('tool'));
    }
}
