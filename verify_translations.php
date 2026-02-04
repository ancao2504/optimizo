<?php

$languages = ['cs', 'da', 'fi', 'id', 'nl', 'no', 'pl', 'ro', 'sv', 'tr', 'vi'];
$tools = [
    'png-to-jpg-converter.json',
    'svg-to-png-converter.json',
    'svg-to-jpg-converter.json',
    'tiff-to-jpg-converter.json',
    'webp-to-jpg-converter.json',
    'webp-to-png-converter.json'
];

$basePath = __DIR__ . '/resources/lang';
$errors = [];

foreach ($languages as $lang) {
    echo "Checking language: $lang\n";
    foreach ($tools as $tool) {
        $file = "$basePath/$lang/tools/image/$tool";

        if (!file_exists($file)) {
            $errors[] = "MISSING: $file";
            continue;
        }

        $content = file_get_contents($file);
        $json = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $errors[] = "JSON ERROR in $file: " . json_last_error_msg();
            continue;
        }

        // Basic structure check
        $requiredKeys = ['meta', 'input', 'editor', 'content'];
        foreach ($requiredKeys as $key) {
            if (!isset($json[$key])) {
                $errors[] = "MISSING KEY '$key' in $file";
            }
        }
    }
}

if (empty($errors)) {
    echo "\nAll files in Batch 9 passed verification!\n";
} else {
    echo "\nFound Errors:\n";
    foreach ($errors as $error) {
        echo "- $error\n";
    }
}
