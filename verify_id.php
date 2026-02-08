<?php
$files = glob('resources/lang/id/tools/image/*.json');
$errors = 0;
foreach ($files as $f) {
    $content = file_get_contents($f);
    $json = json_decode($content);
    if ($json === null) {
        echo basename($f) . ' - JSON ERROR: ' . json_last_error_msg() . PHP_EOL;
        $errors++;
    }
}
echo count($files) . ' files checked, ' . $errors . ' errors' . PHP_EOL;
