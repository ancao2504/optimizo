<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class BlackAndWhiteImageConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'black-and-white-image-converter')->firstOrFail();
        return view("tools.image.black-and-white-image-converter", compact('tool'));
    }
}
