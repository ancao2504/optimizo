<?php
$langs = ['ar', 'cs', 'da', 'de', 'en', 'es', 'fi', 'fr', 'id', 'it', 'ja', 'ko', 'nl', 'no', 'pl', 'pt', 'ro', 'ru', 'sv', 'tr', 'vi', 'zh'];
$tools = ['adler32-hash-generator', 'crc32-hash-generator', 'crc32b-hash-generator', 'md4-hash-generator', 'sha1-hash-generator', 'sha256-hash-generator', 'sha384-hash-generator', 'sha512-hash-generator', 'ripemd128-hash-generator', 'ripemd160-hash-generator', 'tiger128-hash-generator', 'tiger160-hash-generator', 'tiger192-hash-generator', 'whirlpool-hash-generator', 'snefru-hash-generator', 'haval128-hash-generator', 'gost-hash-generator'];

$ok = 0;
$fail = 0;
$miss = 0;
foreach ($langs as $l) {
    foreach ($tools as $t) {
        $f = __DIR__ . "/resources/lang/$l/tools/development/$t.json";
        if (!file_exists($f)) {
            echo "MISS: $l/$t\n";
            $miss++;
            continue;
        }
        $d = json_decode(file_get_contents($f), true);
        if (!$d || !isset($d['meta']) || !isset($d['editor']) || !isset($d['content']) || !isset($d['js'])) {
            echo "FAIL: $l/$t\n";
            $fail++;
        } else {
            $ok++;
        }
    }
}
echo "\nResults: OK=$ok FAIL=$fail MISS=$miss Total=" . ($ok + $fail + $miss) . " (expected 374)\n";
echo "Languages: " . count($langs) . " Tools: " . count($tools) . "\n";
