<?php

namespace App\Http\Controllers\Tools\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;

class SpriteSheetGeneratorController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'sprite-sheet-generator')->firstOrFail();
        return view("tools.image.sprite-sheet-generator", compact('tool'));
    }
}
