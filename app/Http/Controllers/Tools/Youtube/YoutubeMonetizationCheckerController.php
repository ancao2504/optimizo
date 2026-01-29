<?php

namespace App\Http\Controllers\Tools\Youtube;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class YoutubeMonetizationCheckerController extends Controller
{
    public function index()
    {
        $tool = Tool::with(['categoryRelation'])->where('slug', 'youtube-monetization-checker')->active()->firstOrFail();
        return view('tools.youtube.youtube-monetization-checker', compact('tool'));
    }

    public function check(Request $request)
    {
        $request->validate([
            'url' => 'required|string'
        ]);

        $url = $request->url;

        // Try to treat as video URL first to get channel info
        $videoId = $this->extractVideoId($url);

        try {
            if ($videoId) {
                // Fetch video page to check for monetization
                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept-Language' => 'en-US,en;q=0.9'
                ])->get("https://www.youtube.com/watch?v={$videoId}");

                $html = $response->body();

                // Extract channel name
                preg_match('/"author":"([^"]+)"/', $html, $authorMatch);
                $channelName = isset($authorMatch[1]) ? json_decode('"' . $authorMatch[1] . '"') : 'N/A';

                // Check for monetization indicator
                $isMonetized = strpos($html, '"is_monetization_enabled":true') !== false
                    || strpos($html, 'yt_ad') !== false
                    || strpos($html, 'ad_type') !== false;

                // Extract channel thumb (from meta)
                preg_match('/<link itemprop="thumbnailUrl" href="([^"]+)">/', $html, $thumbMatch);
                $thumbnail = $thumbMatch[1] ?? 'https://via.placeholder.com/80';

                // We can't easily get subscribers from video page without complex regex or extra request
                // but we can try common patterns
                preg_match('/"subscriberCountText":{"accessibility":{"accessibilityData":{"label":"([^"]+)"}}}/', $html, $subMatch);
                $subscribers = $subMatch[1] ?? 'N/A';

                $data = [
                    'channelName' => $channelName,
                    'subscribers' => $subscribers,
                    'thumbnail' => $thumbnail,
                    'isMonetized' => $isMonetized,
                    'estimatedStatus' => $isMonetized ? 'Channel is Monetized' : 'Channel is NOT Monetized or indicator not found',
                    'type' => 'video'
                ];
            } else {
                // If not a video, handle as channel URL
                $channelId = $this->extractChannelId($url);
                if (!$channelId) {
                    throw new \Exception('Invalid YouTube URL');
                }

                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept-Language' => 'en-US,en;q=0.9'
                ])->get("https://www.youtube.com/{$channelId}");

                $html = $response->body();

                // On channel home page, we look for membership or store features as proxies
                $isMonetized = strpos($html, '"is_monetization_enabled":true') !== false
                    || strpos($html, '"label":"Join this channel"') !== false
                    || strpos($html, 'sponsor_button') !== false;

                // Extract channel name
                preg_match('/<meta property="og:title" content="([^"]+)"/', $html, $nameMatch);
                $channelName = $nameMatch[1] ?? 'N/A';

                // Extract avatar
                preg_match('/<meta property="og:image" content="([^"]+)"/', $html, $avatarMatch);
                $thumbnail = $avatarMatch[1] ?? 'https://via.placeholder.com/80';

                // Extract subscribers
                if (preg_match('/"subscriberCountText":{"simpleText":"([^"]+)"}/', $html, $subMatch)) {
                    $subscribers = $subMatch[1];
                } elseif (preg_match('/([\d\.]+[KMB]?)\s+subscribers/i', $html, $subMatch)) {
                    $subscribers = $subMatch[1];
                } else {
                    $subscribers = 'N/A';
                }

                $data = [
                    'channelName' => $channelName,
                    'subscribers' => $subscribers,
                    'thumbnail' => $thumbnail,
                    'isMonetized' => $isMonetized,
                    'estimatedStatus' => $isMonetized ? 'Channel is Monetized' : 'Channel shows no immediate signs of monetization',
                    'type' => 'channel'
                ];
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'data' => $data]);
            }

            return back()->with('data', $data);
        } catch (\Exception $e) {
            $error = 'Failed to check monetization status: ' . $e->getMessage();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'error' => $error], 500);
            }
            return back()->with('error', $error);
        }
    }

    private function extractVideoId($url)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        preg_match($pattern, $url, $matches);
        return $matches[1] ?? null;
    }

    private function extractChannelId($url)
    {
        $patterns = [
            '/youtube\.com\/(channel|c|user)\/([^\/\?]+)/',
            '/youtube\.com\/@([^\/\?]+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                if (isset($matches[2])) {
                    return $matches[1] . '/' . $matches[2];
                } elseif (isset($matches[1])) {
                    return '@' . $matches[1];
                }
            }
        }

        return null;
    }
}
