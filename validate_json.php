<?php

$locales = ['fi', 'ja', 'ko'];
$basePath = __DIR__ . '/resources/lang';

foreach ($locales as $locale) {
    $toolsPath = "$basePath/$locale/tools";
    if (!is_dir($toolsPath)) {
        echo "Directory not found: $toolsPath\n";
        continue;
    }

    $files = glob("$toolsPath/*.json");
    foreach ($files as $file) {
        $content = file_get_contents($file);
        $json = json_decode($content);

        if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
            echo "ERROR in $file:\n";
            echo "  " . json_last_error_msg() . "\n";
        } else {
            // echo "OK: $file\n";
        }
    }
}

echo "Validation complete.\n";
