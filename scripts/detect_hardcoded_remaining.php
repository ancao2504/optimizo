<?php

/**
 * Detect remaining hardcoded English strings in ALL tool Blade templates.
 * Writes output to a UTF-8 file for easy reading.
 */

$basePath = realpath(__DIR__ . '/..');
$viewsPath = "$basePath/resources/views/tools";
$outputFile = __DIR__ . '/remaining_issues.txt';

$categories = ['development', 'youtube', 'seo', 'text', 'network', 'utility', 'converters', 'spreadsheet', 'document', 'time'];

$totalFiles = 0;
$totalHardcoded = 0;
$output = [];

foreach ($categories as $category) {
    $categoryPath = "$viewsPath/$category";
    if (!is_dir($categoryPath))
        continue;

    $files = glob("$categoryPath/*.blade.php");
    foreach ($files as $filePath) {
        $filename = basename($filePath, '.blade.php');
        $content = file_get_contents($filePath);
        $totalFiles++;
        $issues = [];

        $lines = explode("\n", $content);
        foreach ($lines as $lineNum => $line) {
            $actualLine = $lineNum + 1;
            $trimmed = trim($line);

            if (
                empty($trimmed) ||
                str_starts_with($trimmed, '{{--') ||
                str_starts_with($trimmed, '@') ||
                str_starts_with($trimmed, '//') ||
                str_starts_with($trimmed, '/*') ||
                str_starts_with($trimmed, '*') ||
                str_starts_with($trimmed, '<script') ||
                str_starts_with($trimmed, '</script') ||
                str_starts_with($trimmed, '<link') ||
                str_starts_with($trimmed, '<meta') ||
                str_starts_with($trimmed, '<svg') ||
                str_starts_with($trimmed, '<path') ||
                str_starts_with($trimmed, '<circle') ||
                str_starts_with($trimmed, '<rect') ||
                str_starts_with($trimmed, '</svg') ||
                str_starts_with($trimmed, 'stroke') ||
                str_starts_with($trimmed, 'fill') ||
                str_starts_with($trimmed, 'd=') ||
                str_starts_with($trimmed, 'viewBox') ||
                str_starts_with($trimmed, 'clip-rule') ||
                str_starts_with($trimmed, 'fill-rule') ||
                str_starts_with($trimmed, 'xmlns')
            )
                continue;

            // Skip lines that are inside <script> blocks
            // We'll use a simple flag approach
            static $inScript = false;
            if (str_contains($line, '<script'))
                $inScript = true;
            if (str_contains($line, '</script')) {
                $inScript = false;
                continue;
            }
            if ($inScript)
                continue;

            // Check for hardcoded English text between HTML tags
            if (preg_match_all('/>\s*([A-Z][a-z]+(?:\s+[a-zA-Z\']+){2,}[^<{]*?)\s*</', $line, $matches)) {
                foreach ($matches[1] as $match) {
                    $match = trim($match);
                    if (strlen($match) < 10)
                        continue;
                    if (str_contains($line, '__tool') || str_contains($line, '__("') || str_contains($line, "__('"))
                        continue;
                    if (str_contains($match, '{{') || str_contains($match, '{!!'))
                        continue;
                    if (preg_match('/^[0-9.]+$/', $match))
                        continue;

                    $issues[] = "  L{$actualLine}: \"{$match}\"";
                    $totalHardcoded++;
                }
            }
        }

        if (!empty($issues)) {
            $output[] = "\n[$category/$filename]";
            $output = array_merge($output, $issues);
        }
    }
}

$output[] = "\n=== Summary ===";
$output[] = "Files scanned: $totalFiles";
$output[] = "Hardcoded English strings found: $totalHardcoded";

$result = implode("\n", $output);
file_put_contents($outputFile, $result, 0);
echo $result;
