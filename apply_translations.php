<?php

$jsonFile = 'translations_batch.json';
if (!file_exists($jsonFile)) {
    die("translations_batch.json not found\n");
}

$batch = json_decode(file_get_contents($jsonFile), true);
if (!$batch) {
    die("Invalid JSON in translations_batch.json\n");
}

foreach ($batch as $lang => $content) {
    $path = "resources/lang/$lang/tools/image/webp-to-jpg-converter.json";

    // Ensure directory exists
    if (!is_dir(dirname($path))) {
        mkdir(dirname($path), 0777, true);
    }

    file_put_contents($path, json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "Updated $lang (" . strlen(json_encode($content)) . " bytes)\n";
}
