<?php

$languages = ['ar', 'cs', 'da', 'de', 'es', 'fi', 'fr', 'id', 'it', 'ja', 'ko', 'nl', 'no', 'pl', 'pt', 'ro', 'ru', 'sv', 'tr', 'vi', 'zh'];
$toolsDir = __DIR__ . '/resources/lang/en/tools/image';
$tools = array_diff(scandir($toolsDir), ['.', '..']);

$issues = [];

function flatten_array($array, $prefix = '')
{
    $result = [];
    foreach ($array as $key => $value) {
        $new_key = $prefix . (empty($prefix) ? '' : '.') . $key;
        if (is_array($value)) {
            $result = array_merge($result, flatten_array($value, $new_key));
        } else {
            $result[$new_key] = $value;
        }
    }
    return $result;
}

foreach ($languages as $lang) {
    echo "Checking language: $lang\n";
    foreach ($tools as $toolFile) {
        $enPath = __DIR__ . "/resources/lang/en/tools/image/$toolFile";
        $targetPath = __DIR__ . "/resources/lang/$lang/tools/image/$toolFile";

        if (!file_exists($targetPath)) {
            $issues[$lang][$toolFile][] = "File missing";
            continue;
        }

        $enContent = json_decode(file_get_contents($enPath), true);
        $targetContent = json_decode(file_get_contents($targetPath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $issues[$lang][$toolFile][] = "Invalid JSON in target file";
            continue;
        }

        $enKeys = flatten_array($enContent);
        $targetKeys = flatten_array($targetContent);

        // Check for missing keys
        foreach (array_keys($enKeys) as $key) {
            if (!array_key_exists($key, $targetKeys)) {
                $issues[$lang][$toolFile][] = "Missing key: $key";
            }
        }

        // Check for extra keys
        foreach (array_keys($targetKeys) as $key) {
            if (!array_key_exists($key, $enKeys)) {
                $issues[$lang][$toolFile][] = "Extra key: $key";
            }
        }

        // Check for empty values
        foreach ($targetKeys as $key => $value) {
            if (empty($value) && $value !== 0 && $value !== '0') {
                $issues[$lang][$toolFile][] = "Empty translation for: $key";
            }
        }
    }
}

$output = "";

if (empty($issues)) {
    $output .= "\nAll translations are in sync!\n";
} else {
    $output .= "\nFound issues:\n";
    foreach ($issues as $lang => $fileIssues) {
        $output .= "\nLanguage: $lang\n";
        foreach ($fileIssues as $file => $fileErrors) {
            $output .= "  File: $file\n";
            foreach ($fileErrors as $error) {
                $output .= "    - $error\n";
            }
        }
    }
}

file_put_contents(__DIR__ . '/translation_report_direct.txt', $output);
echo "Report written to translation_report_direct.txt";

