<?php

namespace App\Http\Controllers\Tools\Seo;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleIndexCheckerController extends Controller
{
    /**
     * Display the Google Index Checker tool page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tool = Tool::where('slug', 'google-index-checker')->first();
        if (!$tool) {
            $tool = new Tool([
                'name' => 'Google Index Checker',
                'slug' => 'google-index-checker',
                'meta_title' => 'Google Index Checker - Check if URL is Indexed',
                'meta_description' => 'Check if a specific web page (URL) has been indexed by Google or not.',
            ]);
        }
        return view("tools.seo.google-index-checker", compact('tool'));
    }

    /**
     * Process the indexing check request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function process(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ], [
            'url.required' => 'Please enter a valid URL.',
            'url.url' => 'Please enter a valid URL format (e.g., https://example.com).'
        ]);

        $targetUrl = $request->input('url');

        try {
            // Remove protocol and trailing slashes for the site: query
            $searchQuery = preg_replace('/^https?:\/\//', '', rtrim($targetUrl, '/'));
            $googleUrl = "https://www.google.com/search?q=" . urlencode("site:" . $searchQuery);

            return response()->json([
                'success' => true,
                'redirect_url' => $googleUrl,
                'message' => 'Redirecting to Google Search...'
            ]);

        } catch (\Exception $e) {
            Log::error('Google Index Checker Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while preparing the check. Please try again.'
            ], 500);
        }
    }
}
