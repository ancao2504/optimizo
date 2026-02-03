<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class ImageCopyrightStampController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'image-copyright-stamp')->firstOrFail();
        return view("tools.image.image-copyright-stamp", compact('tool'));
    }
}
