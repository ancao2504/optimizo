<?php
$langs = ['ar', 'cs', 'da', 'de', 'es', 'fi', 'fr', 'id', 'it', 'ja', 'ko', 'nl', 'no', 'pl', 'pt', 'ro', 'ru', 'sv', 'tr', 'vi', 'zh'];
$results = [];
foreach ($langs as $l) {
    $path = "d:/workspace/optimizo/resources/lang/$l/tools/seo.json";
    if (!file_exists($path)) {
        $results[] = "$l: MISSING";
        continue;
    }
    $content = file_get_contents($path);
    $data = json_decode($content);
    if ($data === null) {
        $results[] = "$l: FAIL (" . json_last_error_msg() . ")";
    } else {
        $results[] = "$l: PASS";
    }
}
echo implode("\n", $results);
if (in_array("FAIL", $results))
    exit(1);
else
    exit(0);
