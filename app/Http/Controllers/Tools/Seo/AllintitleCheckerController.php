<?php

namespace App\Http\Controllers\Tools\Seo;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class AllintitleCheckerController extends Controller
{
    /**
     * Display the Google Allintitle Checker tool page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tool = Tool::where('slug', 'google-allintitle-checker')->firstOrFail();
        return view("tools.seo.allintitle-checker", compact('tool'));
    }

    /**
     * Process the Allintitle check (placeholder for potential backend logic).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function process(Request $request)
    {
        // For now, results are handled client-side via redirection to Google
        return response()->json(['success' => true]);
    }
}
