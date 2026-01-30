<?php

namespace App\Http\Controllers\Tools\Utility;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class UrlOpenerController extends Controller
{
    public function index()
    {
        $tool = Tool::with(['categoryRelation'])->where('slug', 'url-opener')->active()->firstOrFail();
        $limit = 20;
        return view('tools.utility.url-opener', compact('tool', 'limit'));
    }
}
