<?php
$en_files = glob('resources/lang/en/tools/image/*.json');
$en_basenames = array_map('basename', $en_files);
$langs = ['pt', 'ro', 'sv', 'tr', 'vi', 'zh'];

foreach ($langs as $l) {
    echo "\n=== $l ===\n";
    $needs = [];
    foreach ($en_basenames as $base) {
        $target = "resources/lang/$l/tools/image/$base";
        if (!file_exists($target)) {
            $needs[] = $base . ' [MISSING]';
            continue;
        }
        $content = file_get_contents($target);
        $json = json_decode($content, true);
        if (!$json) {
            $needs[] = $base . ' [BAD JSON]';
            continue;
        }
        // Check for English text markers
        $has_english = false;
        if (isset($json['input']['drop_title']) && strpos($json['input']['drop_title'], 'Drag') !== false)
            $has_english = true;
        if (isset($json['content']['features']['title']) && $json['content']['features']['title'] === 'Key Features')
            $has_english = true;
        if (isset($json['editor']['btn_download']) && $json['editor']['btn_download'] === 'Download')
            $has_english = true;
        if ($has_english) {
            $needs[] = $base;
        }
    }
    echo "Needs translation: " . count($needs) . "/" . count($en_basenames) . "\n";
    foreach ($needs as $n)
        echo "  $n\n";
}
