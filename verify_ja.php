<?php
$files = glob('resources/lang/ja/tools/image/*.json');
$errors = 0;
foreach ($files as $f) {
    $c = json_decode(file_get_contents($f));
    if ($c === null) {
        echo "ERROR: $f - " . json_last_error_msg() . "\n";
        $errors++;
    }
}
echo "\nTotal files: " . count($files) . "\n";
echo "Errors: $errors\n";
