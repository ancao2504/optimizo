<?php

$languages = ['ar', 'cs', 'da', 'de', 'es', 'fi', 'fr', 'id', 'it', 'ja', 'ko', 'nl', 'no', 'pl', 'pt', 'ro', 'ru', 'sv', 'tr', 'vi', 'zh'];
$toolsDir = __DIR__ . '/resources/lang/en/tools/image';
$tools = array_diff(scandir($toolsDir), ['.', '..']);

// Smart Renames Map (Old Key in Target -> New Key in EN)
// We use simple string replacement for keys since flattening loses structure, 
// but we need to operate on the full array.
// Actually, it's safer to operate on the flattened array, map keys, then unflatten? 
// No, unflattening is hard.
// Let's rely on recursive traversal.

function sync_arrays($en, $target, &$stats)
{
    $result = [];

    // 1. Process English keys (Source of Truth)
    foreach ($en as $key => $enValue) {
        // Check if key exists in Target
        if (array_key_exists($key, $target)) {
            // Key exists. recurse or copy.
            if (is_array($enValue) && is_array($target[$key])) {
                $result[$key] = sync_arrays($enValue, $target[$key], $stats);
            } elseif (is_array($enValue)) {
                // Type mismatch: EN is array, Target is scalar. Force overwrite structure.
                // But try to see if we can salvage sub-keys from scalar? No.
                $result[$key] = sync_arrays($enValue, [], $stats); // Create structure
            } else {
                // Scalar. Use target value (preserve translation).
                $result[$key] = $target[$key];
            }
        } else {
            // Missing Key in Target.
            // Check for Smart Renames (Heuristic / Manual Map)
            $foundRenamed = false;

            // Heuristics Check:
            // meta.description <-> meta.desc
            if ($key === 'description' && isset($target['desc'])) {
                $result[$key] = $target['desc'];
                $stats['renamed'][] = "desc -> description";
                unset($target['desc']); // Remove so it doesn't get marked as extra
                $foundRenamed = true;
            }
            // reuslt.converted_to <-> editor.converted_to (context dependent)
            // hard to do deeply nested checks without path.

            if (!$foundRenamed) {
                // Really missing. Use English Value.
                $result[$key] = $enValue;
                $stats['added']++;
            }
        }
    }

    // 2. Extra Keys are implicitly removed because we only iterated EN keys to build $result.
    // However, we need to handle specific moves that "cross" branches (e.g. editor.btn -> result.btn).
    // The simple recursion above strictly enforces hierarchy.
    // If 'editor.btn' moved to 'result.btn', the above loop would see 'result.btn' as missing (add EN) 
    // and 'editor.btn' as ignored (removed).
    // Result: Lost translation.

    return $result;
}

// We need a Flatten-Map-Unflatten approach or a Pre-Process Migration approach.
// Let's do Pre-Process Migration on the Target Array before Sync.

function migrate_target($target)
{
    // 1. meta.desc -> meta.description
    if (isset($target['meta']['desc']) && !isset($target['meta']['description'])) {
        $target['meta']['description'] = $target['meta']['desc'];
        unset($target['meta']['desc']);
    }

    // 2. editor -> result moves
    // editor.converted_to -> result.converted_to
    if (isset($target['editor']['converted_to']) && !isset($target['result']['converted_to'])) {
        $target['result']['converted_to'] = $target['editor']['converted_to'];
        unset($target['editor']['converted_to']);
    }
    // editor.image_alt -> result.image_alt
    if (isset($target['editor']['image_alt']) && !isset($target['result']['image_alt'])) {
        $target['result']['image_alt'] = $target['editor']['image_alt'];
        unset($target['editor']['image_alt']);
    }
    // editor.btn_download -> result.btn_download
    if (isset($target['editor']['btn_download']) && !isset($target['result']['btn_download'])) {
        $target['result']['btn_download'] = $target['editor']['btn_download'];
        unset($target['editor']['btn_download']);
    }

    return $target;
}

$totalStats = ['added' => 0, 'renamed' => []];

foreach ($languages as $lang) {
    foreach ($tools as $toolFile) {
        $enPath = __DIR__ . "/resources/lang/en/tools/image/$toolFile";
        $targetPath = __DIR__ . "/resources/lang/$lang/tools/image/$toolFile";

        if (!file_exists($targetPath))
            continue;

        $enContent = json_decode(file_get_contents($enPath), true);
        $targetContent = json_decode(file_get_contents($targetPath), true);

        // 1. Migrate (Rename keys in place)
        $targetContent = migrate_target($targetContent);

        // 2. Sync (Add missing, Remove extra)
        $stats = ['added' => 0, 'renamed' => []];
        $finalContent = sync_arrays($enContent, $targetContent, $stats);

        // 3. Save
        file_put_contents($targetPath, json_encode($finalContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $totalStats['added'] += $stats['added'];
    }
}

echo "Fix complete. Added {$totalStats['added']} missing translation keys (using English defaults).\n";
