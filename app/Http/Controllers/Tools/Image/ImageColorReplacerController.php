<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class ImageColorReplacerController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'image-color-replacer')->firstOrFail();
        return view("tools.image.image-color-replacer", compact('tool'));
    }
}
