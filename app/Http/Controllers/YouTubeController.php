<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class YouTubeController extends Controller
{
    public function thumbnail()
    {
        return view('tools.youtube.youtube-thumbnail-downloader');
    }

    public function downloadThumbnail(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $videoId = $this->extractVideoId($request->url);

        if (!$videoId) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'error' => 'Invalid YouTube URL. Please enter a valid YouTube video URL.'], 400);
            }
            return back()->with('error', 'Invalid YouTube URL');
        }

        $thumbnails = [
            'maxresdefault' => [
                'url' => "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg",
                'quality' => 'Maximum Resolution',
                'resolution' => '1280x720',
                'size' => 'HD'
            ],
            'sddefault' => [
                'url' => "https://img.youtube.com/vi/{$videoId}/sddefault.jpg",
                'quality' => 'Standard Definition (Default)',
                'resolution' => '640x480',
                'size' => 'SD'
            ],
            'hqdefault' => [
                'url' => "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg",
                'quality' => 'High Quality',
                'resolution' => '480x360',
                'size' => 'HQ'
            ],
            'mqdefault' => [
                'url' => "https://img.youtube.com/vi/{$videoId}/mqdefault.jpg",
                'quality' => 'Medium Quality',
                'resolution' => '320x180',
                'size' => 'MQ'
            ],
        ];

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'thumbnails' => $thumbnails, 'videoId' => $videoId]);
        }

        return view('tools.youtube.youtube-thumbnail-downloader', compact('thumbnails', 'videoId'));
    }

    public function extractor()
    {
        return view('tools.youtube.youtube-video-data-extractor');
    }

    public function extractData(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $videoId = $this->extractVideoId($request->url);

        if (!$videoId) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'error' => 'Invalid YouTube URL. Please enter a valid YouTube video URL.'], 400);
            }
            return back()->with('error', 'Invalid YouTube URL');
        }

        // Scrape YouTube page for metadata
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
            ])->get("https://www.youtube.com/watch?v={$videoId}");

            $html = $response->body();

            // Extract title
            preg_match('/"title":"([^"]+)"/', $html, $titleMatch);
            $title = isset($titleMatch[1]) ? json_decode('"' . $titleMatch[1] . '"') : 'N/A';

            // Extract description
            preg_match('/"description":{"simpleText":"([^"]+)"}/', $html, $descMatch);
            if (!isset($descMatch[1])) {
                preg_match('/"shortDescription":"([^"]+)"/', $html, $descMatch);
            }
            $description = isset($descMatch[1]) ? json_decode('"' . $descMatch[1] . '"') : 'N/A';

            // Extract keywords/tags
            preg_match('/"keywords":\[([^\]]+)\]/', $html, $keywordsMatch);
            $tags = 'N/A';
            if (isset($keywordsMatch[1])) {
                $tagsArray = json_decode('[' . $keywordsMatch[1] . ']');
                $tags = is_array($tagsArray) ? implode(', ', $tagsArray) : 'N/A';
            }

            // Extract channel name
            preg_match('/"author":"([^"]+)"/', $html, $authorMatch);
            $channel = isset($authorMatch[1]) ? json_decode('"' . $authorMatch[1] . '"') : 'N/A';

            // Extract view count
            preg_match('/"viewCount":"(\d+)"/', $html, $viewMatch);
            $views = isset($viewMatch[1]) ? number_format($viewMatch[1]) : 'N/A';

            // Extract publish date
            preg_match('/"publishDate":"([^"]+)"/', $html, $dateMatch);
            $publishDate = $dateMatch[1] ?? 'N/A';

            // Extract likes
            preg_match('/"label":"([\d,\.]+[KMB]?) likes?"/', $html, $likesMatch);
            if (!isset($likesMatch[1])) {
                preg_match('/"accessibilityText":"([\d,]+) likes"/', $html, $likesMatch);
            }
            $likes = $likesMatch[1] ?? 'N/A';

            // Extract category
            preg_match('/"category":"([^"]+)"/', $html, $categoryMatch);
            if (!isset($categoryMatch[1])) {
                preg_match('/"genre":"([^"]+)"/', $html, $categoryMatch);
            }
            $category = isset($categoryMatch[1]) ? json_decode('"' . $categoryMatch[1] . '"') : 'N/A';

            // Get thumbnail
            $thumbnail = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";

            $data = [
                'videoId' => $videoId,
                'title' => $title,
                'description' => $description,
                'tags' => $tags,
                'channel' => $channel,
                'views' => $views,
                'likes' => $likes,
                'publishDate' => $publishDate,
                'category' => $category,
                'thumbnail' => $thumbnail,
                'url' => $request->url
            ];

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'data' => $data]);
            }

            return view('tools.youtube.youtube-video-data-extractor', compact('data'));
        } catch (\Exception $e) {
            $error = 'Failed to extract video data. Please try again.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'error' => $error], 500);
            }
            return back()->with('error', $error);
        }
    }

    private function decodeUnicode($str)
    {
        return html_entity_decode(preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }, $str));
    }

    public function tags()
    {
        return view('tools.youtube.youtube-tag-generator');
    }

    public function generateTags(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:255'
        ]);

        $keyword = $request->keyword;

        // Generate related tags based on the keyword
        $tags = $this->generateRelatedTags($keyword);

        return view('tools.youtube.youtube-tag-generator', compact('tags', 'keyword'));
    }

    private function extractVideoId($url)
    {
        // Extract video ID from various YouTube URL formats
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        preg_match($pattern, $url, $matches);
        return $matches[1] ?? null;
    }

    private function generateRelatedTags($keyword)
    {
        // Generate variations and related tags
        $tags = [];

        // Add the main keyword
        $tags[] = $keyword;

        // Add common variations
        $tags[] = strtolower($keyword);
        $tags[] = ucwords($keyword);

        // Add with common suffixes
        $suffixes = ['tutorial', 'guide', 'tips', 'tricks', 'how to', 'review', '2024', 'explained', 'for beginners'];
        foreach ($suffixes as $suffix) {
            $tags[] = $keyword . ' ' . $suffix;
        }

        // Add with common prefixes
        $prefixes = ['best', 'top', 'learn', 'free', 'complete', 'ultimate'];
        foreach ($prefixes as $prefix) {
            $tags[] = $prefix . ' ' . $keyword;
        }

        // Add word combinations if keyword has multiple words
        $words = explode(' ', $keyword);
        if (count($words) > 1) {
            $tags[] = implode('', $words); // No spaces
            $tags[] = implode('-', $words); // Hyphenated
        }

        return array_unique($tags);
    }

    // Channel Data Extractor
    public function channel()
    {
        return view('tools.youtube.youtube-channel-data-extractor');
    }

    public function extractChannelData(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $channelId = $this->extractChannelId($request->url);

        if (!$channelId) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'error' => 'Invalid YouTube channel URL. Please enter a valid YouTube channel URL.'], 400);
            }
            return back()->with('error', 'Invalid YouTube channel URL');
        }

        // Scrape YouTube channel ABOUT page for metadata (more reliable)
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept-Language' => 'en-US,en;q=0.9'
            ])->get("https://www.youtube.com/{$channelId}/about", [
                        'hl' => 'en',
                        'gl' => 'US'
                    ]);

            $html = $response->body();

            // Initialize variables
            $name = 'N/A';
            $description = 'No description available';
            $subscribers = 'Hidden';
            $videoCount = 'N/A';
            $views = 'N/A';
            $joinDate = 'N/A';
            $country = 'N/A';
            $avatar = null;

            // Extract ytInitialData JSON which contains accurate channel data
            if (preg_match('/var ytInitialData = ({.*?});/s', $html, $jsonMatch)) {
                $jsonData = json_decode($jsonMatch[1], true);

                // Get data from header (c4TabbedHeaderRenderer)
                if (isset($jsonData['header']['c4TabbedHeaderRenderer'])) {
                    $header = $jsonData['header']['c4TabbedHeaderRenderer'];

                    if (isset($header['title'])) {
                        $name = $header['title'];
                    }

                    if (isset($header['subscriberCountText']['simpleText'])) {
                        $subscribers = $header['subscriberCountText']['simpleText'];
                    }

                    if (isset($header['videosCountText']['runs'][0]['text'])) {
                        $videoCount = $header['videosCountText']['runs'][0]['text'];
                    }

                    if (isset($header['avatar']['thumbnails'])) {
                        $thumbnails = $header['avatar']['thumbnails'];
                        $avatar = end($thumbnails)['url']; // Get highest quality
                    }
                }

                // Get metadata
                if (isset($jsonData['metadata']['channelMetadataRenderer'])) {
                    $metadata = $jsonData['metadata']['channelMetadataRenderer'];

                    if (isset($metadata['title']) && $name === 'N/A') {
                        $name = $metadata['title'];
                    }

                    if (isset($metadata['description'])) {
                        $description = $metadata['description'] ?: 'No description available';
                    }

                    if (!$avatar && isset($metadata['avatar']['thumbnails'])) {
                        $thumbnails = $metadata['avatar']['thumbnails'];
                        $avatar = end($thumbnails)['url'];
                    }
                }
            }

            // Fallback to meta tags
            if ($name === 'N/A' && preg_match('/<meta property="og:title" content="([^"]+)"/', $html, $match)) {
                $name = $match[1];
            }

            if ($description === 'No description available' && preg_match('/<meta property="og:description" content="([^"]*)"/', $html, $match)) {
                $description = $match[1] ?: 'No description available';
            }

            if (!$avatar && preg_match('/<meta property="og:image" content="([^"]+)"/', $html, $match)) {
                $avatar = $match[1];
            }

            // Extract stats from visible HTML as fallback
            if ($subscribers === 'Hidden' && preg_match('/(\d+(?:\.\d+)?[KMB]?)\s+subscribers?/i', $html, $match)) {
                $subscribers = $match[1] . ' subscribers';
            }

            if ($videoCount === 'N/A' && preg_match('/(\d+(?:,\d+)*)\s+videos?/i', $html, $match)) {
                $videoCount = $match[1];
            }

            if (preg_match('/(\d+(?:,\d+)*(?:\.\d+)?[KMB]?)\s+views?/i', $html, $match)) {
                $views = $match[1] . ' views';
            }

            if (preg_match('/Joined\s+([A-Za-z]+\s+\d+,\s+\d{4})/i', $html, $match)) {
                $joinDate = $match[1];
            }

            $data = [
                'channelId' => $channelId,
                'name' => $name,
                'description' => $description,
                'subscribers' => $subscribers,
                'videoCount' => $videoCount,
                'views' => $views,
                'joinDate' => $joinDate,
                'country' => $country,
                'avatar' => $avatar,
                'url' => $request->url
            ];

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'data' => $data]);
            }

            return view('tools.youtube.youtube-channel-data-extractor', compact('data'));
        } catch (\Exception $e) {
            $error = 'Failed to extract channel data. Please try again.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'error' => $error], 500);
            }
            return back()->with('error', $error);
        }
    }

    private function extractChannelId($url)
    {
        // Match various YouTube channel URL formats
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

    // YouTube Handle Availability Checker
    public function handleChecker()
    {
        return view('tools.youtube.youtube-handle-checker');
    }

    public function checkHandle(Request $request)
    {
        $request->validate([
            'handle' => 'required|string|min:3|max:30'
        ]);

        $handle = $request->handle;

        // Remove @ if present
        $handle = ltrim($handle, '@');

        // Validate handle format (alphanumeric, dots, underscores)
        if (!preg_match('/^[a-zA-Z0-9._]+$/', $handle)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid handle format. Use only letters, numbers, dots, and underscores.'
                ], 400);
            }
            return back()->with('error', 'Invalid handle format');
        }

        try {
            // Check if handle exists by trying to access the channel page
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ])->get("https://www.youtube.com/@{$handle}");

            $statusCode = $response->status();
            $isAvailable = $statusCode === 404;

            $data = [
                'handle' => '@' . $handle,
                'available' => $isAvailable,
                'status' => $isAvailable ? 'Available' : 'Taken',
                'message' => $isAvailable
                    ? "Great news! @{$handle} is available!"
                    : "Sorry, @{$handle} is already taken.",
                'url' => "https://www.youtube.com/@{$handle}"
            ];

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'data' => $data]);
            }

            return view('tools.youtube.youtube-handle-checker', compact('data'));
        } catch (\Exception $e) {
            $error = 'Failed to check handle availability';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'error' => $error], 500);
            }
            return back()->with('error', $error);
        }
    }

    // YouTube Monetization Checker
    public function monetizationChecker()
    {
        return view('tools.youtube.youtube-monetization-checker');
    }

    public function checkMonetization(Request $request)
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

            return view('tools.youtube.youtube-monetization-checker', compact('data'));
        } catch (\Exception $e) {
            $error = 'Failed to check monetization status: ' . $e->getMessage();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'error' => $error], 500);
            }
            return back()->with('error', $error);
        }
    }
}
