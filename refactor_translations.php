<?php

$toolsMap = json_decode(file_get_contents('tools_map.json'), true);
$baseLangDir = base_path('resources/lang');
$locales = array_filter(glob($baseLangDir . '/*'), 'is_dir');

foreach ($locales as $localePath) {
    $locale = basename($localePath);
    echo "Processing locale: $locale\n";

    $toolsDir = $localePath . '/tools';
    if (!is_dir($toolsDir))
        continue;

    foreach ($toolsMap as $categorySlug => $tools) {
        $categoryJsonPath = $toolsDir . '/' . $categorySlug . '.json';

        if (file_exists($categoryJsonPath)) {
            echo "  Found category file: $categorySlug.json\n";
            $categoryData = json_decode(file_get_contents($categoryJsonPath), true);

            if (!$categoryData) {
                echo "    Error decoding $categorySlug.json or empty.\n";
                continue;
            }

            // Create category directory if not exists
            $categoryDirPath = $toolsDir . '/' . $categorySlug;
            if (!is_dir($categoryDirPath)) {
                mkdir($categoryDirPath, 0755, true);
                echo "    Created directory: $categorySlug\n";
            }

            $modified = false;
            foreach ($tools as $toolSlug) {
                if (isset($categoryData[$toolSlug])) {
                    $toolJsonPath = $categoryDirPath . '/' . $toolSlug . '.json';

                    // Don't overwrite if already exists (safe mode), or maybe we should?
                    // User said "create separate files for each tool"
                    // Let's overwrite to ensure it matches the source
                    file_put_contents($toolJsonPath, json_encode($categoryData[$toolSlug], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    echo "    Extracted tool: $toolSlug\n";

                    // Remove from original array based on user request to "move"
                    unset($categoryData[$toolSlug]);
                    $modified = true;
                }
            }

            if ($modified) {
                if (empty($categoryData)) {
                    unlink($categoryJsonPath);
                    echo "    Deleted empty category file: $categorySlug.json\n";
                } else {
                    file_put_contents($categoryJsonPath, json_encode($categoryData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    echo "    Updated category file: $categorySlug.json (removed moved tools)\n";
                }
            }
        }
    }
}

echo "Refactoring complete.\n";
