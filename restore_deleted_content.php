<?php

$files = [
    'resources/lang/en/tools/image/avif-to-jpg-converter.json',
    'resources/lang/en/tools/image/responsive-image-generator.json'
];

$commit = '93ded4e3bbbd824a9db888639c22bcb';

foreach ($files as $file) {
    echo "Processing $file...\n";

    // Get old content directly from git (bypass shell redirection encoding issues)
    $oldJson = shell_exec("git show $commit:$file");
    $oldData = json_decode($oldJson, true);

    if (!$oldData) {
        echo "Failed to retrieve/decode old JSON for $file\n";
        continue;
    }

    $currentPath = __DIR__ . '/' . $file;
    $currentData = json_decode(file_get_contents($currentPath), true);

    // Merge Intro
    if (isset($oldData['content']['intro'])) {
        foreach ($oldData['content']['intro'] as $k => $v) {
            if (!isset($currentData['content']['intro'][$k])) {
                $currentData['content']['intro'][$k] = $v;
                echo "Restored intro.$k\n";
            }
        }
    }

    // Merge Story
    if (isset($oldData['content']['story'])) {
        foreach ($oldData['content']['story'] as $k => $v) {
            if (!isset($currentData['content']['story'][$k])) {
                $currentData['content']['story'][$k] = $v;
                echo "Restored story.$k\n";
            }
        }
    }

    // Merge Why (just in case)
    if (isset($oldData['content']['why'])) {
        if (!isset($currentData['content']['why'])) {
            $currentData['content']['why'] = $oldData['content']['why'];
            echo "Restored content.why section\n";
        }
    }

    // Merge FAQ (just in case)
    if (isset($oldData['content']['faq'])) {
        if (!isset($currentData['content']['faq'])) {
            $currentData['content']['faq'] = $oldData['content']['faq'];
            echo "Restored content.faq section\n";
        }
    }

    // Save
    file_put_contents($currentPath, json_encode($currentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "Saved update to $file\n";
}
