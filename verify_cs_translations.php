<?php

$lang = 'cs';
$basePath = __DIR__ . '/resources/lang';
$enPath = "$basePath/en/tools/image";
$csPath = "$basePath/$lang/tools/image";

$files = scandir($enPath);
$files = array_filter($files, function ($f) {
    return str_ends_with($f, '.json');
});

$errors = [];
$warnings = [];
$checked = 0;

echo "Verifying Czech ($lang) translations against English...\n\n";

foreach ($files as $file) {
    $enFile = "$enPath/$file";
    $csFile = "$csPath/$file";

    if (!file_exists($csFile)) {
        $errors[] = "MISSING FILE: $file";
        continue;
    }

    $enJson = json_decode(file_get_contents($enFile), true);
    $csJson = json_decode(file_get_contents($csFile), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        $errors[] = "JSON ERROR in $file: " . json_last_error_msg();
        continue;
    }

    // Check specific keys for translation
    $keysToCheck = ['meta.title', 'meta.subtitle', 'input.title'];

    foreach ($keysToCheck as $keyPath) {
        $keys = explode('.', $keyPath);
        $enVal = $enJson;
        $csVal = $csJson;

        foreach ($keys as $k) {
            $enVal = $enVal[$k] ?? null;
            $csVal = $csVal[$k] ?? null;
        }

        if ($enVal && $csVal && $enVal === $csVal) {
            $warnings[] = "IDENTICAL: $file -> $keyPath ('$enVal')";
        }

        if (!$csVal) {
            // Some files structure might be different, e.g. input.title not present?
            // But for image tools they usually are.
            // We won't flag missing keys as errors yet, just focusing on identical content.
        }
    }
    $checked++;
}

echo "Checked $checked files.\n";

if (!empty($errors)) {
    echo "\nERRORS:\n";
    foreach ($errors as $e)
        echo "- $e\n";
}

if (!empty($warnings)) {
    echo "\nWARNINGS (Identical to English):\n";
    foreach ($warnings as $w)
        echo "- $w\n";
} else {
    echo "\nSUCCESS: No identical titles found!\n";
}
