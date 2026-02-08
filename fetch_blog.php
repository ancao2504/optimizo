<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$posts = App\Models\Post::select('id', 'title', 'slug', 'status', 'language_code')
    ->orderBy('id', 'desc')
    ->get();

echo "Total posts: " . $posts->count() . "\n\n";
foreach ($posts as $post) {
    echo "ID: {$post->id} | Status: {$post->status} | Lang: {$post->language_code} | Slug: {$post->slug}\n";
    echo "  Title: {$post->title}\n\n";
}
