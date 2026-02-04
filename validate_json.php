<?php

function check($pattern)
{
    foreach (glob($pattern) as $f) {
        $content = file_get_contents($f);
        $json = json_decode($content);
        if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
            echo "ERROR $f: " . json_last_error_msg() . PHP_EOL;
        } else {
            // echo "OK $f" . PHP_EOL;
        }
    }
}

echo "Checking png-to-jpg-converter.json..." . PHP_EOL;
check('resources/lang/*/tools/image/png-to-jpg-converter.json');

echo "Checking image-to-base64-converter.json..." . PHP_EOL;
check('resources/lang/*/tools/image/image-to-base64-converter.json');

echo "Checking pt files..." . PHP_EOL;
check('resources/lang/pt/tools/image/*.json');

echo "Done." . PHP_EOL;
