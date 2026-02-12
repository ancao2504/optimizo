<?php

/**
 * Extract all unique English values from newly added keys.
 * Compares English JSON keys against a target language to find what's missing.
 */

$basePath = realpath(__DIR__ . '/..');
$enToolsPath = "$basePath/resources/lang/en/tools";
$targetLang = 'ko'; // Use Korean as reference target
$targetToolsPath = "$basePath/resources/lang/$targetLang/tools";

$categories = ['image', 'development', 'youtube', 'seo', 'text', 'network', 'utility', 'converters', 'document', 'time'];

$missingKeys = [];
$totalMissing = 0;

function flattenKeys($array, $prefix = '')
{
    $result = [];
    foreach ($array as $key => $value) {
        $fullKey = $prefix ? "$prefix.$key" : $key;
        if (is_array($value)) {
            $result = array_merge($result, flattenKeys($value, $fullKey));
        } else {
            $result[$fullKey] = $value;
        }
    }
    return $result;
}

foreach ($categories as $category) {
    $enCatPath = "$enToolsPath/$category";
    if (!is_dir($enCatPath))
        continue;

    $files = glob("$enCatPath/*.json");
    foreach ($files as $enFile) {
        $slug = basename($enFile, '.json');
        $targetFile = "$targetToolsPath/$category/$slug.json";

        if (!file_exists($targetFile))
            continue;

        $enData = json_decode(file_get_contents($enFile), true) ?: [];
        $targetData = json_decode(file_get_contents($targetFile), true) ?: [];

        $enKeys = flattenKeys($enData);
        $targetKeys = flattenKeys($targetData);

        $missing = array_diff_key($enKeys, $targetKeys);

        if (!empty($missing)) {
            echo "\n[$category/$slug] " . count($missing) . " missing keys:\n";
            foreach ($missing as $key => $value) {
                $short = strlen($value) > 70 ? substr($value, 0, 70) . "..." : $value;
                echo "  $key = \"$short\"\n";
                $totalMissing++;

                // Track unique values
                if (!isset($missingKeys[$value])) {
                    $missingKeys[$value] = [];
                }
                $missingKeys[$value][] = "$category/$slug.$key";
            }
        }
    }
}

echo "\n=== Summary ===\n";
echo "Total missing keys across target lang '$targetLang': $totalMissing\n";
echo "Unique English values: " . count($missingKeys) . "\n";

// Show most common values (shared across many tools)
echo "\n=== Most Common Values (shared across 3+ tools) ===\n";
foreach ($missingKeys as $value => $locations) {
    if (count($locations) >= 3) {
        $short = strlen($value) > 60 ? substr($value, 0, 60) . "..." : $value;
        echo "  \"$short\" (" . count($locations) . " tools)\n";
    }
}
