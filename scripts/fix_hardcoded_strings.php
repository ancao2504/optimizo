<?php

/**
 * Fix hardcoded English strings in Blade tool templates.
 * 
 * This script:
 * 1. Scans all Blade files in resources/views/tools/ for hardcoded English strings
 * 2. Adds corresponding keys to each tool's English JSON file
 * 3. Replaces hardcoded strings in Blade files with __tool() calls
 */

$basePath = realpath(__DIR__ . '/..');
$viewsPath = "$basePath/resources/views/tools";
$langPath = "$basePath/resources/lang";

$totalFixed = 0;
$totalFilesModified = 0;
$totalKeysAdded = 0;

// Common patterns to find and replace across image blade tools
// Format: [regex pattern => [json_key, replacement_template]]
// The regex should capture the tool slug from nearby __tool() calls

$categories = ['image', 'text', 'seo', 'development', 'youtube', 'network', 'utility'];

foreach ($categories as $category) {
    $categoryPath = "$viewsPath/$category";
    if (!is_dir($categoryPath))
        continue;

    $files = glob("$categoryPath/*.blade.php");
    foreach ($files as $filePath) {
        $filename = basename($filePath, '.blade.php');
        $slug = $filename;

        $content = file_get_contents($filePath);
        $originalContent = $content;
        $jsonKeysToAdd = [];

        // ============================================================
        // Pattern 1: "Why Use This Tool?" badge text
        // ============================================================
        if (preg_match('/>Why Use This Tool\?</', $content)) {
            $content = preg_replace(
                '/>(Why Use This Tool\?)<\/span>/',
                '>{{ __tool(\'' . $slug . '\', \'content.features.badge\') ?: \'Why Use This Tool?\' }}</span>',
                $content
            );
            $jsonKeysToAdd['content.features.badge'] = 'Why Use This Tool?';
        }

        // ============================================================
        // Pattern 2: Features subtitle (various per tool)
        // e.g., "Essential for developers and designers."
        //        "Optimized for performance and quality."
        //        "Efficient compression for faster websites."
        // ============================================================
        if (preg_match('/<p class="text-xl text-gray-500 font-light">((?!{{)[^<]+)<\/p>/', $content, $m)) {
            $subtitle = trim($m[1]);
            if (strlen($subtitle) > 5 && !str_contains($subtitle, '__tool') && !str_contains($subtitle, '{{')) {
                $escapedSubtitle = str_replace("'", "\\'", $subtitle);
                $content = str_replace(
                    '<p class="text-xl text-gray-500 font-light">' . $subtitle . '</p>',
                    '<p class="text-xl text-gray-500 font-light">{{ __tool(\'' . $slug . '\', \'content.features.subtitle\') ?: \'' . $escapedSubtitle . '\' }}</p>',
                    $content
                );
                $jsonKeysToAdd['content.features.subtitle'] = $subtitle;
            }
        }

        // ============================================================
        // Pattern 3: How-to subtitle
        // e.g., "Simple steps to decode your images."
        //        "Simple steps to high-efficiency images."
        //        "Simple steps to smaller files."
        // ============================================================
        if (preg_match('/<p class="text-gray-400 text-lg">((?!{{)[^<]+)<\/p>/', $content, $m)) {
            $howToSubtitle = trim($m[1]);
            if (strlen($howToSubtitle) > 5 && !str_contains($howToSubtitle, '__tool') && !str_contains($howToSubtitle, '{{')) {
                $escapedSubtitle = str_replace("'", "\\'", $howToSubtitle);
                $content = str_replace(
                    '<p class="text-gray-400 text-lg">' . $howToSubtitle . '</p>',
                    '<p class="text-gray-400 text-lg">{{ __tool(\'' . $slug . '\', \'content.how_to.subtitle\') ?: \'' . $escapedSubtitle . '\' }}</p>',
                    $content
                );
                $jsonKeysToAdd['content.how_to.subtitle'] = $howToSubtitle;
            }
        }

        // ============================================================
        // Pattern 4: "Upload New Image" / "Compress Another Image" button
        // ============================================================
        if (preg_match('/>\s*(Upload New Image|Compress Another Image|Upload Another)\s*</', $content, $m)) {
            $buttonText = trim($m[1]);
            $escapedText = str_replace("'", "\\'", $buttonText);
            $content = preg_replace(
                '/>\s*' . preg_quote($buttonText, '/') . '\s*<\/button>/',
                '>{{ __tool(\'' . $slug . '\', \'editor.btn_upload_new\') ?: \'' . $escapedText . '\' }}</button>',
                $content
            );
            $jsonKeysToAdd['editor.btn_upload_new'] = $buttonText;
        }

        // ============================================================
        // Pattern 5: "Your image is ready to download" (base64-to-image specific)
        // ============================================================
        if (str_contains($content, 'Your image is ready to download')) {
            $content = str_replace(
                'Your image is ready to download',
                '{{ __tool(\'' . $slug . '\', \'result.ready_message\') ?: \'Your image is ready to download\' }}',
                $content
            );
            $jsonKeysToAdd['result.ready_message'] = 'Your image is ready to download';
        }

        // ============================================================
        // Pattern 6: "Paste your Base64 string here" (base64-to-image specific)
        // ============================================================
        if (preg_match('/>\s*Paste your Base64 string here\s*</', $content)) {
            $content = str_replace(
                'Paste your Base64 string here',
                '{{ __tool(\'' . $slug . '\', \'input.label\') ?: \'Paste your Base64 string here\' }}',
                $content
            );
            $jsonKeysToAdd['input.label'] = 'Paste your Base64 string here';
        }

        // ============================================================
        // Save changes to Blade file
        // ============================================================
        if ($content !== $originalContent) {
            file_put_contents($filePath, $content);
            $totalFilesModified++;
            $replacements = substr_count($content, '__tool(') - substr_count($originalContent, '__tool(');
            $totalFixed += max($replacements, count($jsonKeysToAdd));
            echo "[BLADE] $category/$filename.blade.php - fixed " . count($jsonKeysToAdd) . " hardcoded strings\n";
        }

        // ============================================================
        // Add keys to English JSON file
        // ============================================================
        if (!empty($jsonKeysToAdd)) {
            $jsonFilePath = "$langPath/en/tools/$category/$slug.json";
            if (file_exists($jsonFilePath)) {
                $jsonContent = json_decode(file_get_contents($jsonFilePath), true);
                if ($jsonContent === null) {
                    echo "  [WARN] Could not parse $category/$slug.json\n";
                    continue;
                }

                $keysAdded = 0;
                foreach ($jsonKeysToAdd as $dotKey => $value) {
                    // Navigate the dot notation to set nested value
                    $parts = explode('.', $dotKey);
                    $ref = &$jsonContent;
                    foreach ($parts as $i => $part) {
                        if ($i === count($parts) - 1) {
                            // Final key
                            if (!isset($ref[$part])) {
                                $ref[$part] = $value;
                                $keysAdded++;
                            }
                        } else {
                            if (!isset($ref[$part]) || !is_array($ref[$part])) {
                                $ref[$part] = [];
                            }
                            $ref = &$ref[$part];
                        }
                    }
                    unset($ref);
                }

                if ($keysAdded > 0) {
                    file_put_contents($jsonFilePath, json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                    $totalKeysAdded += $keysAdded;
                    echo "  [JSON] en/tools/$category/$slug.json - added $keysAdded keys\n";
                }
            }
        }
    }
}

echo "\n=== Summary ===\n";
echo "Blade files modified: $totalFilesModified\n";
echo "Total hardcoded strings replaced: $totalFixed\n";
echo "JSON keys added: $totalKeysAdded\n";
