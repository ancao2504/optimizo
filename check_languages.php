<?php

use App\Models\Language;
use Illuminate\Support\Facades\Cache;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$languages = Language::all();

foreach ($languages as $lang) {
    echo "Code: " . $lang->code . " | Active: " . $lang->is_active . " | Default: " . $lang->is_default . "\n";
}
