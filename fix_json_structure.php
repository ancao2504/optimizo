<?php

$toolsDir = __DIR__ . '/resources/lang/en/tools/image';
$files = array_diff(scandir($toolsDir), ['.', '..']);

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) !== 'json')
        continue;

    $path = "$toolsDir/$file";
    $jsonContent = file_get_contents($path);
    if (!$jsonContent)
        continue;

    $data = json_decode($jsonContent, true);
    if (!is_array($data))
        continue;

    $modified = false;

    // --- Fix Features ---
    if (isset($data['content']['features'])) {
        $features = $data['content']['features'];

        // Check for nested structure or missing title
        $isNested = false;
        foreach ($features as $key => $val) {
            if ($key === 'title')
                continue;
            if (is_array($val) && (isset($val['title']) || isset($val['desc']))) {
                $isNested = true;
                break;
            }
        }

        // If nested OR title remains displayed as raw key (missing from data)
        if ($isNested || !isset($features['title'])) {
            echo "Fixing features for $file\n";
            $newFeatures = [];

            // 1. Preserve or Add Title
            if (isset($features['title'])) {
                $newFeatures['title'] = $features['title'];
            } else {
                $newFeatures['title'] = "Key Features"; // Default
                $modified = true;
            }

            // 2. Normalize Items
            $i = 1;
            foreach ($features as $key => $val) {
                if ($key === 'title')
                    continue;

                // If already flat (f1_title), preserve it
                if (preg_match('/^f\d+_/', $key)) {
                    $newFeatures[$key] = $val;
                    // update index to avoid collision? assuming sequential
                    continue;
                }

                // If nested object (universal: { title, desc })
                if (is_array($val)) {
                    $newFeatures["f{$i}_title"] = $val['title'] ?? ucwords(str_replace('_', ' ', $key));
                    $newFeatures["f{$i}_desc"] = $val['desc'] ?? '';
                    $i++;
                    $modified = true;
                }
            }
            $data['content']['features'] = $newFeatures;
        }
    }

    // --- Fix How-To ---
    // Check if list exists OR title is missing
    $hasList = isset($data['content']['how_to']['list']) && is_array($data['content']['how_to']['list']);
    $missingTitle = !isset($data['content']['how_to']['title']);

    if ($hasList || $missingTitle) {
        // Only report if we are doing substantive change
        if ($hasList || $missingTitle)
            echo "Fixing how_to for $file\n";

        $newHowTo = [];

        // 1. Title
        $newHowTo['title'] = $data['content']['how_to']['title'] ?? "How to Use";

        // 2. Items
        // Preserve existing flat steps
        if (isset($data['content']['how_to'])) {
            foreach ($data['content']['how_to'] as $k => $v) {
                if (preg_match('/^step\d+_/', $k)) {
                    $newHowTo[$k] = $v;
                }
            }
        }

        // Flatten 'list' if exists
        if ($hasList) {
            foreach ($data['content']['how_to']['list'] as $index => $text) {
                $i = $index + 1;
                // Avoid overwriting if 'step1_desc' already exists?
                // Actually list usually implies we need to generate steps.
                if (!isset($newHowTo["step{$i}_desc"])) {
                    $newHowTo["step{$i}_title"] = "Step $i";
                    $newHowTo["step{$i}_desc"] = $text;
                    $modified = true;
                }
            }
        }

        if ($missingTitle)
            $modified = true;

        $data['content']['how_to'] = $newHowTo;
    }

    // --- Fix FAQ Title ---
    if (isset($data['content']['faq']) && !isset($data['content']['faq']['title'])) {
        echo "Adding FAQ title for $file\n";
        $data['content']['faq']['title'] = "Frequently Asked Questions";
        $modified = true;
    }

    if ($modified) {
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

echo "Done fixing JSON structures.\n";
