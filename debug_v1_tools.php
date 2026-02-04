<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$slugs = [
    'image-to-base64-converter',
    'png-to-webp-converter',
    'svg-to-jpg-converter'
];
$locales = ['en', 'fr'];

foreach ($slugs as $slug) {
    echo "------------------------------------------------" . PHP_EOL;
    echo "DEBUGGING SLUG: $slug" . PHP_EOL;
    foreach ($locales as $locale) {
        app()->setLocale($locale);
        echo "  LOCALE: $locale" . PHP_EOL;

        $title = __tool($slug, 'content.title', false);
        $p1 = __tool($slug, 'content.p1', false);

        echo "    content.title: " . ($title ? "FOUND (" . substr($title, 0, 15) . "...)" : "NOT FOUND") . PHP_EOL;
        echo "    content.p1   : " . ($p1 ? "FOUND" : "NOT FOUND") . PHP_EOL;

        $hasV1 = ($title || $p1);
        echo "    HAS V1 CONTENT: " . ($hasV1 ? "YES" : "NO") . PHP_EOL;
    }
}
echo "------------------------------------------------" . PHP_EOL;
