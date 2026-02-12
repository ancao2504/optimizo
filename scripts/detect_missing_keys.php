<?php
/**
 * Detect missing translation keys across all languages.
 * Compares each language's tool JSON files against the English (en) versions
 * and reports which keys are present in English but missing in the target language.
 */

$basePath = realpath(__DIR__ . '/../resources/lang');
$enPath = $basePath . '/en';

// Languages to check (the ones reported as problematic)
$targetLangs = ['id', 'ja', 'ko', 'nl', 'no', 'pl', 'ro', 'sv', 'tr', 'zh'];

// Function to flatten a nested array into dot-notation keys
function flattenKeys($array, $prefix = '')
{
    $result = [];
    foreach ($array as $key => $value) {
        $fullKey = $prefix ? "$prefix.$key" : $key;
        if (is_array($value)) {
            $result = array_merge($result, flattenKeys($value, $fullKey));
        } else {
            $result[$fullKey] = $value;
        }
    }
    return $result;
}

// Recursively find all JSON files in a directory
function findJsonFiles($dir, $baseDir = null)
{
    if ($baseDir === null)
        $baseDir = $dir;
    $files = [];
    foreach (glob("$dir/*") as $path) {
        if (is_dir($path)) {
            $files = array_merge($files, findJsonFiles($path, $baseDir));
        } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'json') {
            $files[] = str_replace($baseDir . '/', '', str_replace('\\', '/', $path));
        }
    }
    return $files;
}

// Get all English tool JSON files
$enToolsPath = $enPath . '/tools';
$enFiles = findJsonFiles($enToolsPath);
sort($enFiles);

$totalMissing = 0;
$missingByLang = [];
$missingByFile = [];

foreach ($targetLangs as $lang) {
    $langPath = $basePath . '/' . $lang;
    $langToolsPath = $langPath . '/tools';
    $langMissing = 0;

    foreach ($enFiles as $relFile) {
        $enFile = $enToolsPath . '/' . $relFile;
        $langFile = $langToolsPath . '/' . $relFile;

        if (!file_exists($enFile))
            continue;

        $enData = json_decode(file_get_contents($enFile), true);
        if (!$enData)
            continue;

        $enKeys = flattenKeys($enData);

        if (!file_exists($langFile)) {
            // Entire file is missing
            $missingByFile["$lang/$relFile"] = array_keys($enKeys);
            $langMissing += count($enKeys);
            continue;
        }

        $langData = json_decode(file_get_contents($langFile), true);
        if (!$langData) {
            $missingByFile["$lang/$relFile"] = ['INVALID_JSON'];
            continue;
        }

        $langKeys = flattenKeys($langData);
        $missing = array_diff_key($enKeys, $langKeys);

        if (!empty($missing)) {
            $missingByFile["$lang/$relFile"] = array_keys($missing);
            $langMissing += count($missing);
        }
    }

    $missingByLang[$lang] = $langMissing;
    $totalMissing += $langMissing;
}

// Also check pages.json
echo "=== PAGES.JSON CHECK ===\n";
$enPagesFile = $enPath . '/pages.json';
if (file_exists($enPagesFile)) {
    $enPagesData = json_decode(file_get_contents($enPagesFile), true);
    $enPagesKeys = flattenKeys($enPagesData);

    foreach ($targetLangs as $lang) {
        $langPagesFile = $basePath . '/' . $lang . '/pages.json';
        if (!file_exists($langPagesFile)) {
            echo "  $lang: pages.json MISSING\n";
            continue;
        }
        $langPagesData = json_decode(file_get_contents($langPagesFile), true);
        $langPagesKeys = flattenKeys($langPagesData);
        $missing = array_diff_key($enPagesKeys, $langPagesKeys);
        if (!empty($missing)) {
            echo "  $lang: " . count($missing) . " missing keys in pages.json\n";
            foreach (array_keys($missing) as $k) {
                echo "    - $k\n";
            }
        } else {
            echo "  $lang: OK\n";
        }
    }
}

// Also check categories.php
echo "\n=== CATEGORIES.PHP CHECK ===\n";
foreach ($targetLangs as $lang) {
    $langCatFile = $basePath . '/' . $lang . '/categories.php';
    $enCatFile = $enPath . '/categories.php';
    if (!file_exists($langCatFile)) {
        echo "  $lang: categories.php MISSING\n";
    } elseif (file_exists($enCatFile)) {
        $enCats = include $enCatFile;
        $langCats = include $langCatFile;
        if (is_array($enCats) && is_array($langCats)) {
            $missing = array_diff_key(flattenKeys($enCats), flattenKeys($langCats));
            if (!empty($missing)) {
                echo "  $lang: " . count($missing) . " missing keys in categories.php\n";
            } else {
                echo "  $lang: OK\n";
            }
        }
    }
}

echo "\n=== TOOL FILES SUMMARY ===\n";
echo "Total missing keys across all languages: $totalMissing\n\n";

foreach ($missingByLang as $lang => $count) {
    echo "  $lang: $count missing keys\n";
}

echo "\n=== DETAILED MISSING KEYS BY FILE ===\n";
foreach ($missingByFile as $file => $keys) {
    echo "\n[$file] (" . count($keys) . " missing keys):\n";
    // Show first 10 keys max per file to keep output manageable
    $shown = 0;
    foreach ($keys as $k) {
        echo "  - $k\n";
        $shown++;
        if ($shown >= 15) {
            echo "  ... and " . (count($keys) - 15) . " more\n";
            break;
        }
    }
}
