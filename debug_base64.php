<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$slug = 'image-to-base64-converter';
app()->setLocale('en');

echo "Slug: $slug\n";
echo "Title: " . __tool($slug, 'content.title', 'DEFAULT_NOT_FOUND') . "\n";
echo "P1: " . __tool($slug, 'content.p1', 'DEFAULT_NOT_FOUND') . "\n";

$hasV2Content =
    __tool($slug, "content.intro", false) ||
    __tool($slug, "content.story", false) ||
    __tool($slug, "content.features.f1_title", false) ||
    __tool($slug, "content.how_to.step1_title", false) ||
    __tool($slug, "content.faq.q1", false);

echo "Has V2 Content: " . ($hasV2Content ? "YES" : "NO") . "\n";
echo "Check specific V2 keys:\n";
echo "  content.intro: " . (__tool($slug, "content.intro", false) ? 'YES' : 'NO') . "\n";
echo "  content.story: " . (__tool($slug, "content.story", false) ? 'YES' : 'NO') . "\n";
echo "  content.features.f1_title: " . (__tool($slug, "content.features.f1_title", false) ? 'YES' : 'NO') . "\n";
echo "  content.how_to.step1_title: " . (__tool($slug, "content.how_to.step1_title", false) ? 'YES' : 'NO') . "\n";
echo "  content.faq.q1: " . (__tool($slug, "content.faq.q1", false) ? 'YES' : 'NO') . "\n";

