<?php

namespace App\Http\Controllers\Tools\Youtube;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class YoutubeVideoDownloaderController extends Controller
{
    public function index()
    {
        $tool = Tool::with(['categoryRelation'])->where('slug', 'youtube-video-downloader')->active()->first();

        if (!$tool) {
            $tool = new Tool([
                'name' => 'YouTube Video Downloader',
                'description' => 'Download YouTube videos in MP4, WebM, MP3, and more.',
                'slug' => 'youtube-video-downloader'
            ]);
        }

        return view('tools.youtube.youtube-video-downloader', compact('tool'));
    }

    public function process(Request $request)
    {
        set_time_limit(300); // 5 minutes
        $request->validate([
            'url' => 'required|url'
        ]);

        $url = $request->url;

        // Optimizations: Force IPv4 (fixes IPv6 stalling), No Playlist (only 1 video), No Check Certificate
        $command = array_merge($this->getCommandPrefix(), [
            '--dump-json',
            '--no-warnings',
            '--force-ipv4',
            '--no-playlist',
            '--no-check-certificate',
            $url
        ]);

        // Environment variables
        $env = [];
        if (PHP_OS_FAMILY === 'Windows') {
            $env = [
                'SystemRoot' => getenv('SystemRoot'),
                'PATH' => getenv('PATH'),
                'TEMP' => getenv('TEMP'),
                'RelPath' => '.'
            ];
        } else {
            // On Linux/Server, explicitly pass PATH to ensure custom locations are included
            $env = ['PATH' => getenv('PATH')];
        }

        Log::info('YouTube Downloader Command:', ['cmd' => implode(' ', $command)]);

        // Increase timeout to 5 minutes (300s) to handle slow server connections
        $result = Process::env($env)->timeout(300)->run($command);

        if ($result->failed()) {
            $error = $result->errorOutput();
            if (empty($error)) {
                $error = $result->output();
            }

            Log::error('YouTube Downloader Failed:', ['error' => $error, 'output' => $result->output()]);

            if ($request->ajax() || $request->wantsJson()) {
                // Return actual error for debugging (remove in production if sensitive)
                return response()->json(['success' => false, 'error' => 'Server Error: ' . substr($error, 0, 200)], 500);
            }
            return back()->with('error', 'Failed to extract video data');
        }

        $json = $result->output();
        $metadata = json_decode($json, true);

        if (!$metadata) {
            return response()->json(['success' => false, 'error' => 'Failed to parse video metadata'], 500);
        }

        $data = [
            'videoId' => $metadata['id'],
            'title' => $metadata['title'],
            'description' => $metadata['description'] ?? '',
            'thumbnail' => $metadata['thumbnail'] ?? '',
            'duration' => $metadata['duration'] ?? 0,
            'view_count' => $metadata['view_count'] ?? 0,
            'url' => $url,
            'qualities' => [
                ['id' => '1080p', 'label' => '1080p (MP4)', 'description' => 'High Definition', 'icon' => 'hd', 'format_str' => 'bestvideo[height<=1080]+bestaudio/best[height<=1080]'],
                ['id' => '720p', 'label' => '720p (MP4)', 'description' => 'HD Ready', 'icon' => 'sd', 'format_str' => 'bestvideo[height<=720]+bestaudio/best[height<=720]'],
                ['id' => '480p', 'label' => '480p (MP4)', 'description' => 'Standard', 'icon' => 'sd', 'format_str' => 'bestvideo[height<=480]+bestaudio/best[height<=480]'],
                ['id' => '360p', 'label' => '360p (MP4)', 'description' => 'Low Data', 'icon' => 'sd', 'format_str' => 'bestvideo[height<=360]+bestaudio/best[height<=360]'],
                ['id' => 'audio', 'label' => 'Audio (MP3)', 'description' => 'Best Quality Audio', 'icon' => 'audio', 'format_str' => 'bestaudio/best', 'ext' => 'mp3'],
            ]
        ];

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $data]);
        }

        return view('tools.youtube.youtube-video-downloader', compact('data'));
    }

    /**
     * Start the download process and stream progress via SSE (Server-Sent Events)
     */
    public function downloadSearch(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'format_str' => 'required|string',
            'title' => 'nullable|string',
            'ext' => 'nullable|string'
        ]);

        $url = $request->input('url');
        $formatStr = $request->input('format_str');
        $ext = $request->input('ext', 'mp4');
        $title = $request->input('title', 'video');
        $filename = Str::slug($title) . '_' . Str::random(6) . '.' . $ext;

        // Ensure temp directory exists
        if (!file_exists(storage_path('app/public/temp/youtube'))) {
            mkdir(storage_path('app/public/temp/youtube'), 0755, true);
        }

        $outputPath = storage_path('app/public/temp/youtube/' . $filename);

        return response()->stream(function () use ($url, $formatStr, $ext, $outputPath, $filename) {
            // Disable timeouts
            set_time_limit(0);
            ob_implicit_flush(true);

            $cmd = array_merge($this->getCommandPrefix(), ['-o', $outputPath, '--newline', '--progress']);

            if ($ext === 'mp3') {
                $cmd = array_merge($cmd, ['-x', '--audio-format', 'mp3', '--audio-quality', '0']);
            } else {
                $cmd = array_merge($cmd, ['-f', $formatStr, '--merge-output-format', $ext]);
            }

            $cmd[] = $url;

            // Build command string for popen
            // Note: On Windows, we need to handle env vars if we use popen directly, 
            // but popen inherits parent env by default.
            $commandStr = implode(' ', array_map('escapeshellarg', $cmd));

            // On windows, we might want to ensure ffmpeg is in path or basic envs are set
            // Ideally we would use proc_open to pass env, but popen is easier for direct reading

            $descriptorSpec = [
                0 => ["pipe", "r"],
                1 => ["pipe", "w"],
                2 => ["pipe", "w"]
            ];

            $env = null;
            if (PHP_OS_FAMILY === 'Windows') {
                $env = [
                    'SystemRoot' => getenv('SystemRoot'),
                    'PATH' => getenv('PATH'),
                    'TEMP' => getenv('TEMP'),
                    'RelPath' => '.'
                ];
            }

            $process = proc_open($commandStr, $descriptorSpec, $pipes, null, $env);

            if (is_resource($process)) {
                $buffer = "";
                while (!feof($pipes[1])) {
                    $line = fgets($pipes[1]);
                    if ($line) {
                        // Extract progress percentage
                        // format: [download]  15.4% of 10.00MiB at 2.50MiB/s ETA 00:03
                        if (preg_match('/(\d+(\.\d+)?)%/', $line, $matches)) {
                            $percent = $matches[1];
                            echo "data: " . json_encode(['progress' => $percent]) . "\n\n";
                            if (ob_get_level() > 0)
                                ob_flush();
                            flush();
                        }
                    }
                }

                fclose($pipes[0]);
                fclose($pipes[1]);
                fclose($pipes[2]);
                proc_close($process);

                // Done
                echo "data: " . json_encode(['progress' => 100, 'done' => true, 'filename' => $filename]) . "\n\n";
                if (ob_get_level() > 0)
                    ob_flush();
                flush();
            } else {
                echo "data: " . json_encode(['error' => 'Failed to start process']) . "\n\n";
                flush();
            }

        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no' // Nginx specific
        ]);
    }

    public function downloadFile(Request $request)
    {
        $filename = $request->input('filename');
        if (!$filename)
            abort(404);

        $path = storage_path('app/public/temp/youtube/' . basename($filename));

        if (!file_exists($path))
            abort(404);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    private function getCommandPrefix()
    {
        if (PHP_OS_FAMILY === 'Windows') {
            return ['yt-dlp'];
        }
        // Server command as requested
        return ['python3.12', '-m', 'yt_dlp'];
    }
}
