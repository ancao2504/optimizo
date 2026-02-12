<?php
// Check that Phase 3 keys exist in target languages
$basePath = realpath(__DIR__ . '/..');
$targetLangs = ['ko', 'zh', 'ja', 'tr'];

// Check digital-signature
echo "=== Digital Signature ===\n";
$enFile = "$basePath/resources/lang/en/tools/document/digital-signature.json";
$enData = json_decode(file_get_contents($enFile), true);
echo "[en] editor.upload_text: " . ($enData['editor']['upload_text'] ?? 'NOT SET') . "\n";
echo "[en] modal.title: " . ($enData['modal']['title'] ?? 'NOT SET') . "\n";

foreach ($targetLangs as $lang) {
    $file = "$basePath/resources/lang/$lang/tools/document/digital-signature.json";
    if (!file_exists($file)) {
        echo "[$lang] FILE NOT FOUND\n";
        continue;
    }
    $d = json_decode(file_get_contents($file), true);
    echo "[$lang] editor.upload_text: " . ($d['editor']['upload_text'] ?? 'NOT SET') . "\n";
    echo "[$lang] modal.title: " . ($d['modal']['title'] ?? 'NOT SET') . "\n";
}

// Check frequency-converter
echo "\n=== Frequency Converter ===\n";
$enFile = "$basePath/resources/lang/en/tools/converters/frequency-converter.json";
$enData = json_decode(file_get_contents($enFile), true);
echo "[en] content.card1_title: " . ($enData['content']['card1_title'] ?? 'NOT SET') . "\n";

foreach ($targetLangs as $lang) {
    $file = "$basePath/resources/lang/$lang/tools/converters/frequency-converter.json";
    if (!file_exists($file)) {
        echo "[$lang] FILE NOT FOUND\n";
        continue;
    }
    $d = json_decode(file_get_contents($file), true);
    echo "[$lang] content.card1_title: " . ($d['content']['card1_title'] ?? 'NOT SET') . "\n";
}

// Check sitemap-validator
echo "\n=== Sitemap Validator ===\n";
$enFile = "$basePath/resources/lang/en/tools/seo/sitemap-validator.json";
$enData = json_decode(file_get_contents($enFile), true);
echo "[en] results.valid_title: " . ($enData['results']['valid_title'] ?? 'NOT SET') . "\n";

foreach ($targetLangs as $lang) {
    $file = "$basePath/resources/lang/$lang/tools/seo/sitemap-validator.json";
    if (!file_exists($file)) {
        echo "[$lang] FILE NOT FOUND\n";
        continue;
    }
    $d = json_decode(file_get_contents($file), true);
    echo "[$lang] results.valid_title: " . ($d['results']['valid_title'] ?? 'NOT SET') . "\n";
}

// Check utc-to-local-time
echo "\n=== UTC to Local Time ===\n";
$enFile = "$basePath/resources/lang/en/tools/time/utc-to-local-time.json";
$enData = json_decode(file_get_contents($enFile), true);
echo "[en] content.local_vs_utc_title: " . ($enData['content']['local_vs_utc_title'] ?? 'NOT SET') . "\n";

foreach ($targetLangs as $lang) {
    $file = "$basePath/resources/lang/$lang/tools/time/utc-to-local-time.json";
    if (!file_exists($file)) {
        echo "[$lang] FILE NOT FOUND\n";
        continue;
    }
    $d = json_decode(file_get_contents($file), true);
    echo "[$lang] content.local_vs_utc_title: " . ($d['content']['local_vs_utc_title'] ?? 'NOT SET') . "\n";
}
