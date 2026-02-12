<?php

/**
 * Fix remaining hardcoded English strings in non-image tool Blade templates.
 * Targets: frequency-converter, digital-signature, utc-to-local-time, sitemap-validator-results
 */

$basePath = realpath(__DIR__ . '/..');
$viewsPath = "$basePath/resources/views/tools";
$langPath = "$basePath/resources/lang/en/tools";

$totalReplacements = 0;
$totalKeysAdded = 0;

// ============================================
// 1. frequency-converter.blade.php
// ============================================
$file = "$viewsPath/converters/frequency-converter.blade.php";
$slug = 'frequency-converter';
$json = "$langPath/converters/$slug.json";

$replacements = [
    // Line 86-87
    [
        'find' => '<h3 class="text-lg font-bold text-gray-900 mb-2">Frequency Units</h3>',
        'replace' => '<h3 class="text-lg font-bold text-gray-900 mb-2">{{ __tool(\'frequency-converter\', \'content.card1_title\') ?: \'Frequency Units\' }}</h3>',
        'key' => 'content.card1_title',
        'value' => 'Frequency Units'
    ],
    [
        'find' => '<p class="text-gray-600">Convert between Hz, kHz, MHz, GHz, RPM, and more frequency units.</p>',
        'replace' => '<p class="text-gray-600">{{ __tool(\'frequency-converter\', \'content.card1_desc\') ?: \'Convert between Hz, kHz, MHz, GHz, RPM, and more frequency units.\' }}</p>',
        'key' => 'content.card1_desc',
        'value' => 'Convert between Hz, kHz, MHz, GHz, RPM, and more frequency units.'
    ],
    // Line 96-97
    [
        'find' => '<h3 class="text-lg font-bold text-gray-900 mb-2">Electronics & Computing</h3>',
        'replace' => '<h3 class="text-lg font-bold text-gray-900 mb-2">{{ __tool(\'frequency-converter\', \'content.card2_title\') ?: \'Electronics & Computing\' }}</h3>',
        'key' => 'content.card2_title',
        'value' => 'Electronics & Computing'
    ],
    [
        'find' => '<p class="text-gray-600">Perfect for CPU speeds, radio frequencies, and wave calculations.</p>',
        'replace' => '<p class="text-gray-600">{{ __tool(\'frequency-converter\', \'content.card2_desc\') ?: \'Perfect for CPU speeds, radio frequencies, and wave calculations.\' }}</p>',
        'key' => 'content.card2_desc',
        'value' => 'Perfect for CPU speeds, radio frequencies, and wave calculations.'
    ],
    // Line 106-107
    [
        'find' => '<h3 class="text-lg font-bold text-gray-900 mb-2">Cycles Per Second</h3>',
        'replace' => '<h3 class="text-lg font-bold text-gray-900 mb-2">{{ __tool(\'frequency-converter\', \'content.card3_title\') ?: \'Cycles Per Second\' }}</h3>',
        'key' => 'content.card3_title',
        'value' => 'Cycles Per Second'
    ],
    [
        'find' => '<p class="text-gray-600">Accurate conversions for oscillations, rotations, and wave frequencies.</p>',
        'replace' => '<p class="text-gray-600">{{ __tool(\'frequency-converter\', \'content.card3_desc\') ?: \'Accurate conversions for oscillations, rotations, and wave frequencies.\' }}</p>',
        'key' => 'content.card3_desc',
        'value' => 'Accurate conversions for oscillations, rotations, and wave frequencies.'
    ],
];

processFile($file, $json, $slug, $replacements, $totalReplacements, $totalKeysAdded);

// ============================================
// 2. utc-to-local-time.blade.php
// ============================================
$file = "$viewsPath/time/utc-to-local-time.blade.php";
$slug = 'utc-to-local-time';
$json = "$langPath/time/$slug.json";

$replacements = [
    [
        'find' => '<h3 class="text-xl font-bold text-gray-900 mb-2">Local vs UTC</h3>',
        'replace' => '<h3 class="text-xl font-bold text-gray-900 mb-2">{{ __tool(\'utc-to-local-time\', \'content.local_vs_utc_title\') ?: \'Local vs UTC\' }}</h3>',
        'key' => 'content.local_vs_utc_title',
        'value' => 'Local vs UTC'
    ],
    [
        'find' => "Local time is the time in your specific time zone, which may include adjustments for daylight saving\r\n                    time. UTC is the worldwide baseline that stays constant regardless of location or season.",
        'replace' => "{{ __tool('utc-to-local-time', 'content.local_vs_utc_desc') ?: 'Local time is the time in your specific time zone, which may include adjustments for daylight saving time. UTC is the worldwide baseline that stays constant regardless of location or season.' }}",
        'key' => 'content.local_vs_utc_desc',
        'value' => 'Local time is the time in your specific time zone, which may include adjustments for daylight saving time. UTC is the worldwide baseline that stays constant regardless of location or season.'
    ],
];

processFile($file, $json, $slug, $replacements, $totalReplacements, $totalKeysAdded);

// ============================================
// 3. digital-signature.blade.php
// ============================================
$file = "$viewsPath/document/digital-signature.blade.php";
$slug = 'digital-signature';
$json = "$langPath/document/$slug.json";

$replacements = [
    // Title and description
    [
        'find' => "@section('title', 'Digital Signature - Free Online Document Signing Tool')",
        'replace' => "@section('title', __tool('digital-signature', 'meta.title', 'Digital Signature - Free Online Document Signing Tool'))",
        'key' => 'meta.title',
        'value' => 'Digital Signature - Free Online Document Signing Tool'
    ],
    [
        'find' => "@section('meta_description', 'Sign PDF documents online for free. Upload your PDF, draw or type your signature, and download the signed document securely.')",
        'replace' => "@section('meta_description', __tool('digital-signature', 'meta.description', 'Sign PDF documents online for free. Upload your PDF, draw or type your signature, and download the signed document securely.'))",
        'key' => 'meta.description',
        'value' => 'Sign PDF documents online for free. Upload your PDF, draw or type your signature, and download the signed document securely.'
    ],
    // Upload section
    [
        'find' => '<p class="text-xl font-bold text-gray-700">Drop your PDF here or click to upload</p>',
        'replace' => '<p class="text-xl font-bold text-gray-700">{{ __tool(\'digital-signature\', \'editor.upload_text\') ?: \'Drop your PDF here or click to upload\' }}</p>',
        'key' => 'editor.upload_text',
        'value' => 'Drop your PDF here or click to upload'
    ],
    [
        'find' => '<p class="text-base text-gray-500 mt-2">Maximum file size: 10MB</p>',
        'replace' => '<p class="text-base text-gray-500 mt-2">{{ __tool(\'digital-signature\', \'editor.max_file_size\') ?: \'Maximum file size: 10MB\' }}</p>',
        'key' => 'editor.max_file_size',
        'value' => 'Maximum file size: 10MB'
    ],
    // Page navigation
    [
        'find' => '<span class="text-sm font-medium text-gray-700">Page <span x-text="currentPage"></span> of <span',
        'replace' => '<span class="text-sm font-medium text-gray-700">{{ __tool(\'digital-signature\', \'editor.page_label\') ?: \'Page\' }} <span x-text="currentPage"></span> {{ __tool(\'digital-signature\', \'editor.page_of\') ?: \'of\' }} <span',
        'key' => 'editor.page_label',
        'value' => 'Page'
    ],
    // Buttons
    [
        'find' => "                            Add Signature\r\n",
        'replace' => "                            {{ __tool('digital-signature', 'editor.btn_add_signature') ?: 'Add Signature' }}\r\n",
        'key' => 'editor.btn_add_signature',
        'value' => 'Add Signature'
    ],
    [
        'find' => "                            Download PDF\r\n",
        'replace' => "                            {{ __tool('digital-signature', 'editor.btn_download') ?: 'Download PDF' }}\r\n",
        'key' => 'editor.btn_download',
        'value' => 'Download PDF'
    ],
    // Modal
    [
        'find' => '<h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">Create Signature</h3>',
        'replace' => '<h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">{{ __tool(\'digital-signature\', \'modal.title\') ?: \'Create Signature\' }}</h3>',
        'key' => 'modal.title',
        'value' => 'Create Signature'
    ],
    // Tab buttons
    [
        'find' => 'class="flex-1 py-2 px-4 border-b-2 font-medium text-sm">Draw</button>',
        'replace' => 'class="flex-1 py-2 px-4 border-b-2 font-medium text-sm">{{ __tool(\'digital-signature\', \'modal.tab_draw\') ?: \'Draw\' }}</button>',
        'key' => 'modal.tab_draw',
        'value' => 'Draw'
    ],
    [
        'find' => 'class="flex-1 py-2 px-4 border-b-2 font-medium text-sm">Type</button>',
        'replace' => 'class="flex-1 py-2 px-4 border-b-2 font-medium text-sm">{{ __tool(\'digital-signature\', \'modal.tab_type\') ?: \'Type\' }}</button>',
        'key' => 'modal.tab_type',
        'value' => 'Type'
    ],
    [
        'find' => 'class="flex-1 py-2 px-4 border-b-2 font-medium text-sm">Upload</button>',
        'replace' => 'class="flex-1 py-2 px-4 border-b-2 font-medium text-sm">{{ __tool(\'digital-signature\', \'modal.tab_upload\') ?: \'Upload\' }}</button>',
        'key' => 'modal.tab_upload',
        'value' => 'Upload'
    ],
    // Clear button
    [
        'find' => 'class="absolute top-2 right-2 text-xs bg-white border border-gray-200 px-2 py-1 rounded text-gray-500 hover:text-red-500">Clear</button>',
        'replace' => 'class="absolute top-2 right-2 text-xs bg-white border border-gray-200 px-2 py-1 rounded text-gray-500 hover:text-red-500">{{ __tool(\'digital-signature\', \'modal.btn_clear\') ?: \'Clear\' }}</button>',
        'key' => 'modal.btn_clear',
        'value' => 'Clear'
    ],
    // Placeholder
    [
        'find' => 'placeholder="Type your name"',
        'replace' => 'placeholder="{{ __tool(\'digital-signature\', \'modal.ph_name\') ?: \'Type your name\' }}"',
        'key' => 'modal.ph_name',
        'value' => 'Type your name'
    ],
    // Create Signature button
    [
        'find' => "                        Create Signature\r\n                    </button>\r\n                    <button @click=\"showModal = false\"",
        'replace' => "                        {{ __tool('digital-signature', 'modal.btn_create') ?: 'Create Signature' }}\r\n                    </button>\r\n                    <button @click=\"showModal = false\"",
        'key' => 'modal.btn_create',
        'value' => 'Create Signature'
    ],
    // Cancel button
    [
        'find' => "                        Cancel\r\n                    </button>",
        'replace' => "                        {{ __tool('digital-signature', 'modal.btn_cancel') ?: 'Cancel' }}\r\n                    </button>",
        'key' => 'modal.btn_cancel',
        'value' => 'Cancel'
    ],
];

processFile($file, $json, $slug, $replacements, $totalReplacements, $totalKeysAdded);

// ============================================
// 4. sitemap-validator-results.blade.php
// ============================================
$file = "$viewsPath/seo/sitemap-validator-results.blade.php";
$slug = 'sitemap-validator';
$json = "$langPath/seo/$slug.json";

$replacements = [
    [
        'find' => '<h3 class="text-2xl font-bold text-green-800">Valid Sitemap!</h3>',
        'replace' => '<h3 class="text-2xl font-bold text-green-800">{{ __tool(\'sitemap-validator\', \'results.valid_title\', \'Valid Sitemap!\') }}</h3>',
        'key' => 'results.valid_title',
        'value' => 'Valid Sitemap!'
    ],
    [
        'find' => '<p class="text-green-600">Your sitemap is properly formatted and ready to submit.</p>',
        'replace' => '<p class="text-green-600">{{ __tool(\'sitemap-validator\', \'results.valid_desc\', \'Your sitemap is properly formatted and ready to submit.\') }}</p>',
        'key' => 'results.valid_desc',
        'value' => 'Your sitemap is properly formatted and ready to submit.'
    ],
    [
        'find' => '<h3 class="text-2xl font-bold text-red-800">Invalid Sitemap</h3>',
        'replace' => '<h3 class="text-2xl font-bold text-red-800">{{ __tool(\'sitemap-validator\', \'results.invalid_title\', \'Invalid Sitemap\') }}</h3>',
        'key' => 'results.invalid_title',
        'value' => 'Invalid Sitemap'
    ],
    [
        'find' => '<p class="text-red-600">Please fix the errors below.</p>',
        'replace' => '<p class="text-red-600">{{ __tool(\'sitemap-validator\', \'results.invalid_desc\', \'Please fix the errors below.\') }}</p>',
        'key' => 'results.invalid_desc',
        'value' => 'Please fix the errors below.'
    ],
    // Stats labels
    [
        'find' => '<div class="text-sm text-gray-600">Sitemaps</div>',
        'replace' => '<div class="text-sm text-gray-600">{{ __tool(\'sitemap-validator\', \'results.label_sitemaps\', \'Sitemaps\') }}</div>',
        'key' => 'results.label_sitemaps',
        'value' => 'Sitemaps'
    ],
    [
        'find' => '<div class="text-sm text-gray-600">Total URLs</div>',
        'replace' => '<div class="text-sm text-gray-600">{{ __tool(\'sitemap-validator\', \'results.label_total_urls\', \'Total URLs\') }}</div>',
        'key' => 'results.label_total_urls',
        'value' => 'Total URLs'
    ],
    [
        'find' => '<div class="text-sm text-gray-600">URLs</div>',
        'replace' => '<div class="text-sm text-gray-600">{{ __tool(\'sitemap-validator\', \'results.label_urls\', \'URLs\') }}</div>',
        'key' => 'results.label_urls',
        'value' => 'URLs'
    ],
    [
        'find' => '<div class="text-sm text-gray-600">File Size</div>',
        'replace' => '<div class="text-sm text-gray-600">{{ __tool(\'sitemap-validator\', \'results.label_file_size\', \'File Size\') }}</div>',
        'key' => 'results.label_file_size',
        'value' => 'File Size'
    ],
    [
        'find' => '<div class="text-sm text-gray-600">Errors</div>',
        'replace' => '<div class="text-sm text-gray-600">{{ __tool(\'sitemap-validator\', \'results.label_errors\', \'Errors\') }}</div>',
        'key' => 'results.label_errors',
        'value' => 'Errors'
    ],
    [
        'find' => '<div class="text-sm text-gray-600">Warnings</div>',
        'replace' => '<div class="text-sm text-gray-600">{{ __tool(\'sitemap-validator\', \'results.label_warnings\', \'Warnings\') }}</div>',
        'key' => 'results.label_warnings',
        'value' => 'Warnings'
    ],
    // Section headings
    [
        'find' => '<h4 class="text-lg font-bold text-red-600 mb-3">Errors</h4>',
        'replace' => '<h4 class="text-lg font-bold text-red-600 mb-3">{{ __tool(\'sitemap-validator\', \'results.errors_heading\', \'Errors\') }}</h4>',
        'key' => 'results.errors_heading',
        'value' => 'Errors'
    ],
    [
        'find' => '<h4 class="text-lg font-bold text-yellow-600 mb-3">Warnings</h4>',
        'replace' => '<h4 class="text-lg font-bold text-yellow-600 mb-3">{{ __tool(\'sitemap-validator\', \'results.warnings_heading\', \'Warnings\') }}</h4>',
        'key' => 'results.warnings_heading',
        'value' => 'Warnings'
    ],
    // Table headers
    [
        'find' => '<th class="p-2 text-left">Sitemap URL</th>',
        'replace' => '<th class="p-2 text-left">{{ __tool(\'sitemap-validator\', \'results.th_sitemap_url\', \'Sitemap URL\') }}</th>',
        'key' => 'results.th_sitemap_url',
        'value' => 'Sitemap URL'
    ],
    [
        'find' => '<th class="p-2 text-left">Status</th>',
        'replace' => '<th class="p-2 text-left">{{ __tool(\'sitemap-validator\', \'results.th_status\', \'Status\') }}</th>',
        'key' => 'results.th_status',
        'value' => 'Status'
    ],
    [
        'find' => '<th class="p-2 text-left">URL</th>',
        'replace' => '<th class="p-2 text-left">{{ __tool(\'sitemap-validator\', \'results.th_url\', \'URL\') }}</th>',
        'key' => 'results.th_url',
        'value' => 'URL'
    ],
    [
        'find' => '<th class="p-2">Last Modified</th>',
        'replace' => '<th class="p-2">{{ __tool(\'sitemap-validator\', \'results.th_last_modified\', \'Last Modified\') }}</th>',
        'key' => 'results.th_last_modified',
        'value' => 'Last Modified'
    ],
    [
        'find' => '<th class="p-2">Change Freq</th>',
        'replace' => '<th class="p-2">{{ __tool(\'sitemap-validator\', \'results.th_change_freq\', \'Change Freq\') }}</th>',
        'key' => 'results.th_change_freq',
        'value' => 'Change Freq'
    ],
    [
        'find' => '<th class="p-2">Priority</th>',
        'replace' => '<th class="p-2">{{ __tool(\'sitemap-validator\', \'results.th_priority\', \'Priority\') }}</th>',
        'key' => 'results.th_priority',
        'value' => 'Priority'
    ],
];

processFile($file, $json, $slug, $replacements, $totalReplacements, $totalKeysAdded);

echo "\n=== COMPLETE ===\n";
echo "Total replacements: $totalReplacements\n";
echo "Total JSON keys added: $totalKeysAdded\n";


/**
 * Process a single file: replace hardcoded strings and add JSON keys
 */
function processFile($file, $jsonFile, $slug, $replacements, &$totalReplacements, &$totalKeysAdded)
{
    if (!file_exists($file)) {
        echo "SKIP: $file not found\n";
        return;
    }

    $content = file_get_contents($file);
    $replaced = 0;

    foreach ($replacements as $r) {
        if (strpos($content, $r['find']) !== false) {
            $content = str_replace($r['find'], $r['replace'], $content);
            $replaced++;
        } else {
            echo "  WARN: Not found in " . basename($file) . ": \"" . substr($r['find'], 0, 60) . "...\"\n";
        }
    }

    if ($replaced > 0) {
        file_put_contents($file, $content);
        echo "[$slug] $replaced replacements in " . basename($file) . "\n";
        $totalReplacements += $replaced;
    }

    // Add keys to JSON
    if (file_exists($jsonFile)) {
        $json = json_decode(file_get_contents($jsonFile), true);
    } else {
        $json = [];
        // Ensure directory exists
        $dir = dirname($jsonFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    $keysAdded = 0;
    foreach ($replacements as $r) {
        // Only add if the key doesn't already exist
        $keyParts = explode('.', $r['key']);
        $exists = true;
        $ref = $json;
        foreach ($keyParts as $part) {
            if (!isset($ref[$part])) {
                $exists = false;
                break;
            }
            $ref = $ref[$part];
        }

        if (!$exists) {
            // Set nested key
            $ref = &$json;
            for ($i = 0; $i < count($keyParts) - 1; $i++) {
                if (!isset($ref[$keyParts[$i]])) {
                    $ref[$keyParts[$i]] = [];
                }
                $ref = &$ref[$keyParts[$i]];
            }
            $ref[end($keyParts)] = $r['value'];
            $keysAdded++;
        }
    }

    if ($keysAdded > 0) {
        file_put_contents($jsonFile, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        echo "  + $keysAdded keys added to " . basename($jsonFile) . "\n";
        $totalKeysAdded += $keysAdded;
    }
}
