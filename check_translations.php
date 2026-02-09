<?php
// Check which files in the user's list still have English content
$urls = [
    // ja
    'ja' => [
        'tools/image/avif-to-jpg-converter',
        'tools/image/avif-to-png-converter',
        'tools/image/base64-to-image-converter',
        'tools/image/black-and-white-image-converter',
        'tools/image/bmp-to-jpg-converter',
        'tools/image/grayscale-image-converter',
        'tools/image/heic-to-jpg-converter',
        'tools/image/ico-converter',
        'tools/image/image-brightness-contrast-adjuster',
        'tools/image/image-color-picker',
        'tools/image/image-color-replacer',
        'tools/image/image-compressor',
        'tools/image/image-converter',
        'tools/image/image-copyright-stamp',
        'tools/image/image-lazy-load-generator',
        'tools/image/image-metadata-remover',
        'tools/image/image-metadata-viewer',
        'tools/image/image-noise-reducer',
        'tools/image/image-sharpener',
        'tools/image/image-to-base64-converter',
        'tools/image/jpg-to-heic-converter',
        'tools/image/jpg-to-png-converter',
        'tools/image/jpg-to-webp-converter',
        'tools/image/png-to-heic-converter',
        'tools/image/png-to-jpg-converter',
        'tools/image/png-to-webp-converter',
        'tools/image/raw-to-jpg-converter',
        'tools/image/responsive-image-generator',
        'tools/image/sprite-sheet-generator',
        'tools/image/svg-to-jpg-converter',
        'tools/image/svg-to-png-converter',
    ],
    // ko
    'ko' => [
        'tools/text/duplicate-line-remover',
        'tools/converters/json-to-yaml-converter',
        'tools/time/local-time-to-utc',
        'tools/utility/random-number-generator',
        'tools/development/xml-formatter',
    ],
    // nl
    'nl' => [
        'tools/image/ico-converter',
        'tools/image/image-brightness-contrast-adjuster',
        'tools/image/image-color-picker',
        'tools/image/image-color-replacer',
        'tools/image/image-copyright-stamp',
        'tools/image/image-lazy-load-generator',
        'tools/image/image-metadata-remover',
        'tools/image/image-metadata-viewer',
        'tools/image/image-noise-reducer',
        'tools/image/image-sharpener',
        'tools/image/jpg-to-heic-converter',
        'tools/image/png-to-heic-converter',
        'tools/image/png-to-jpg-converter',
        'tools/image/png-to-webp-converter',
        'tools/image/raw-to-jpg-converter',
        'tools/image/responsive-image-generator',
        'tools/image/sprite-sheet-generator',
        'tools/image/svg-to-jpg-converter',
    ],
    // no
    'no' => [
        'tools/image/avif-to-jpg-converter',
        'tools/image/avif-to-png-converter',
        'tools/image/black-and-white-image-converter',
        'tools/image/bmp-to-jpg-converter',
        'tools/image/grayscale-image-converter',
        'tools/image/image-brightness-contrast-adjuster',
        'tools/image/image-color-picker',
        'tools/image/image-color-replacer',
        'tools/image/image-copyright-stamp',
        'tools/image/image-lazy-load-generator',
        'tools/image/image-metadata-remover',
        'tools/image/image-metadata-viewer',
        'tools/image/image-noise-reducer',
        'tools/image/image-sharpener',
        'tools/image/jpg-to-heic-converter',
        'tools/image/png-to-heic-converter',
        'tools/image/png-to-jpg-converter',
        'tools/image/png-to-webp-converter',
        'tools/image/raw-to-jpg-converter',
        'tools/image/responsive-image-generator',
        'tools/image/sprite-sheet-generator',
    ],
    // pl
    'pl' => [
        'tools/image/avif-to-jpg-converter',
        'tools/image/avif-to-png-converter',
        'tools/image/black-and-white-image-converter',
        'tools/image/bmp-to-jpg-converter',
        'tools/image/grayscale-image-converter',
        'tools/image/ico-converter',
        'tools/image/image-brightness-contrast-adjuster',
        'tools/image/image-color-picker',
        'tools/image/image-color-replacer',
        'tools/image/image-copyright-stamp',
        'tools/image/image-lazy-load-generator',
        'tools/image/image-metadata-remover',
        'tools/image/image-metadata-viewer',
        'tools/image/image-noise-reducer',
        'tools/image/image-sharpener',
        'tools/image/jpg-to-heic-converter',
        'tools/image/png-to-heic-converter',
        'tools/image/raw-to-jpg-converter',
        'tools/image/responsive-image-generator',
        'tools/image/sprite-sheet-generator',
    ],
    // pt
    'pt' => [
        'tools/image/base64-to-image-converter',
        'tools/image/svg-to-jpg-converter',
    ],
    // ro
    'ro' => [
        'tools/image/avif-to-jpg-converter',
        'tools/image/avif-to-png-converter',
        'tools/image/black-and-white-image-converter',
        'tools/image/bmp-to-jpg-converter',
        'tools/image/grayscale-image-converter',
        'tools/image/ico-converter',
        'tools/image/image-brightness-contrast-adjuster',
        'tools/image/image-color-picker',
        'tools/image/image-color-replacer',
        'tools/image/image-copyright-stamp',
        'tools/image/image-lazy-load-generator',
        'tools/image/image-metadata-remover',
        'tools/image/image-metadata-viewer',
        'tools/image/image-noise-reducer',
        'tools/image/image-sharpener',
        'tools/image/jpg-to-heic-converter',
        'tools/image/png-to-heic-converter',
        'tools/image/png-to-jpg-converter',
        'tools/image/png-to-webp-converter',
        'tools/image/raw-to-jpg-converter',
        'tools/image/responsive-image-generator',
        'tools/image/sprite-sheet-generator',
    ],
    // sv
    'sv' => [
        'tools/image/base64-to-image-converter',
        'tools/image/black-and-white-image-converter',
        'tools/image/bmp-to-jpg-converter',
        'tools/image/grayscale-image-converter',
        'tools/image/ico-converter',
        'tools/image/image-brightness-contrast-adjuster',
        'tools/image/image-color-picker',
        'tools/image/image-color-replacer',
        'tools/image/image-copyright-stamp',
        'tools/image/image-lazy-load-generator',
        'tools/image/image-metadata-remover',
        'tools/image/image-metadata-viewer',
        'tools/image/image-noise-reducer',
        'tools/image/image-sharpener',
        'tools/image/image-to-base64-converter',
        'tools/image/jpg-to-heic-converter',
        'tools/image/png-to-heic-converter',
        'tools/image/png-to-jpg-converter',
        'tools/image/png-to-webp-converter',
        'tools/image/raw-to-jpg-converter',
        'tools/image/responsive-image-generator',
        'tools/image/sprite-sheet-generator',
    ],
    // tr
    'tr' => [
        'tools/image/avif-to-jpg-converter',
        'tools/image/avif-to-png-converter',
        'tools/image/black-and-white-image-converter',
        'tools/image/bmp-to-jpg-converter',
        'tools/image/grayscale-image-converter',
        'tools/image/image-brightness-contrast-adjuster',
        'tools/image/image-color-replacer',
        'tools/image/image-copyright-stamp',
        'tools/image/image-lazy-load-generator',
        'tools/image/image-metadata-remover',
        'tools/image/image-metadata-viewer',
        'tools/image/image-noise-reducer',
        'tools/image/image-sharpener',
        'tools/image/jpg-to-heic-converter',
        'tools/image/raw-to-jpg-converter',
        'tools/image/responsive-image-generator',
        'tools/image/sprite-sheet-generator',
    ],
    // vi
    'vi' => [
        'tools/image/avif-to-png-converter',
        'tools/image/black-and-white-image-converter',
        'tools/image/image-color-replacer',
        'tools/image/image-copyright-stamp',
        'tools/image/image-metadata-remover',
        'tools/image/image-metadata-viewer',
        'tools/image/image-noise-reducer',
        'tools/image/jpg-to-heic-converter',
        'tools/image/png-to-heic-converter',
        'tools/image/raw-to-jpg-converter',
    ],
    // zh
    'zh' => [
        'tools/development/html-minifier',
        'tools/development/html-to-markdown-converter',
        'tools/development/html-viewer',
        'tools/development/json-formatter',
        'tools/document/pdf-to-word',
        'tools/youtube/youtube-tag-generator',
        'tools/youtube/youtube-video-downloader',
        'tools/youtube/youtube-video-tags-extractor',
    ],
];

$totalNeeded = 0;
$totalAlready = 0;
foreach ($urls as $lang => $files) {
    $needed = 0;
    $already = 0;
    foreach ($files as $file) {
        $path = "resources/lang/$lang/$file.json";
        if (!file_exists($path)) {
            echo "MISSING: $path\n";
            $needed++;
            continue;
        }
        $content = json_decode(file_get_contents($path), true);
        if ($content === null) {
            echo "INVALID JSON: $path\n";
            $needed++;
            continue;
        }
        // Check if meta.title is in English (contains common English words)
        $title = $content['meta']['title'] ?? '';
        if (preg_match('/^[A-Za-z0-9\s\-\|&,.:!\'()]+$/', $title)) {
            $needed++;
        } else {
            $already++;
        }
    }
    echo "[$lang] Need translation: $needed | Already translated: $already\n";
    $totalNeeded += $needed;
    $totalAlready += $already;
}
echo "\nTotal needing translation: $totalNeeded\n";
echo "Total already translated: $totalAlready\n";
