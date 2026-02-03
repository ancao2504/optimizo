<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class AvifToJpgConverterController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'avif-to-jpg-converter')->firstOrFail();
        return view("tools.image.avif-to-jpg-converter", compact('tool'));
    }
}
