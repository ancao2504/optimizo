<?php

/**
 * Fix missing video-downloader keys in categories.php files for all target languages.
 */

$basePath = __DIR__ . '/../resources/lang';

$targetLanguages = ['id', 'ja', 'ko', 'nl', 'no', 'pl', 'ro', 'sv', 'tr', 'zh'];

// Translations for video-downloader keys per language
$translations = [
    'id' => [
        'video-downloader_title' => 'Alat Pengunduh Video',
        'video-downloader_subtitle' => 'Alat pengunduh video profesional - 100% gratis, tanpa registrasi',
        'video-downloader_meta_title' => 'Alat Pengunduh Video - Pengunduh Video Online Gratis | Optimizo',
        'video-downloader_meta_description' => 'Unduh video dari berbagai platform secara gratis. Pengunduh video berkualitas tinggi untuk YouTube, Facebook, Instagram, dan lainnya.',
        'video-downloader_h1' => 'Alat Pengunduh Video',
    ],
    'ja' => [
        'video-downloader_title' => 'ビデオダウンロードツール',
        'video-downloader_subtitle' => 'プロフェッショナルなビデオダウンロードツール - 100%無料、登録不要',
        'video-downloader_meta_title' => 'ビデオダウンロードツール - 無料オンラインビデオダウンローダー | Optimizo',
        'video-downloader_meta_description' => '様々なプラットフォームから無料で動画をダウンロード。YouTube、Facebook、Instagramなどの高品質ビデオダウンローダー。',
        'video-downloader_h1' => 'ビデオダウンロードツール',
    ],
    'ko' => [
        'video-downloader_title' => '비디오 다운로더 도구',
        'video-downloader_subtitle' => '전문 비디오 다운로드 도구 - 100% 무료, 가입 불필요',
        'video-downloader_meta_title' => '비디오 다운로더 도구 - 무료 온라인 비디오 다운로더 | Optimizo',
        'video-downloader_meta_description' => '다양한 플랫폼에서 무료로 비디오를 다운로드하세요. YouTube, Facebook, Instagram 등을 위한 고품질 비디오 다운로더.',
        'video-downloader_h1' => '비디오 다운로더 도구',
    ],
    'nl' => [
        'video-downloader_title' => 'Video Downloader Tools',
        'video-downloader_subtitle' => 'Professionele video-downloadtools - 100% gratis, geen registratie nodig',
        'video-downloader_meta_title' => 'Video Downloader Tools - Gratis Online Video Downloaders | Optimizo',
        'video-downloader_meta_description' => 'Download gratis video\'s van verschillende platforms. Hoogwaardige video-downloaders voor YouTube, Facebook, Instagram en meer.',
        'video-downloader_h1' => 'Video Downloader Tools',
    ],
    'no' => [
        'video-downloader_title' => 'Videonedlastingsverktøy',
        'video-downloader_subtitle' => 'Profesjonelle videonedlastingsverktøy - 100% gratis, ingen registrering nødvendig',
        'video-downloader_meta_title' => 'Videonedlastingsverktøy - Gratis Online Videonedlastere | Optimizo',
        'video-downloader_meta_description' => 'Last ned videoer fra ulike plattformer gratis. Høykvalitets videonedlastere for YouTube, Facebook, Instagram og mer.',
        'video-downloader_h1' => 'Videonedlastingsverktøy',
    ],
    'pl' => [
        'video-downloader_title' => 'Narzędzia do pobierania wideo',
        'video-downloader_subtitle' => 'Profesjonalne narzędzia do pobierania wideo - 100% darmowe, bez rejestracji',
        'video-downloader_meta_title' => 'Narzędzia do pobierania wideo - Darmowe pobieranie filmów online | Optimizo',
        'video-downloader_meta_description' => 'Pobieraj filmy z różnych platform za darmo. Wysokiej jakości narzędzia do pobierania filmów z YouTube, Facebook, Instagram i innych.',
        'video-downloader_h1' => 'Narzędzia do pobierania wideo',
    ],
    'ro' => [
        'video-downloader_title' => 'Instrumente de descărcare video',
        'video-downloader_subtitle' => 'Instrumente profesionale de descărcare video - 100% gratuit, fără înregistrare',
        'video-downloader_meta_title' => 'Instrumente de descărcare video - Descărcatoare de video online gratuite | Optimizo',
        'video-downloader_meta_description' => 'Descărcați videoclipuri de pe diverse platforme gratuit. Descărcatoare de video de înaltă calitate pentru YouTube, Facebook, Instagram și altele.',
        'video-downloader_h1' => 'Instrumente de descărcare video',
    ],
    'sv' => [
        'video-downloader_title' => 'Videonedladdningsverktyg',
        'video-downloader_subtitle' => 'Professionella videonedladdningsverktyg - 100% gratis, ingen registrering krävs',
        'video-downloader_meta_title' => 'Videonedladdningsverktyg - Gratis nedladdning av videor online | Optimizo',
        'video-downloader_meta_description' => 'Ladda ner videor från olika plattformar gratis. Högkvalitativa videonedladdare för YouTube, Facebook, Instagram och mer.',
        'video-downloader_h1' => 'Videonedladdningsverktyg',
    ],
    'tr' => [
        'video-downloader_title' => 'Video İndirme Araçları',
        'video-downloader_subtitle' => 'Profesyonel video indirme araçları - %100 ücretsiz, kayıt gerektirmez',
        'video-downloader_meta_title' => 'Video İndirme Araçları - Ücretsiz Çevrimiçi Video İndiriciler | Optimizo',
        'video-downloader_meta_description' => 'Çeşitli platformlardan ücretsiz video indirin. YouTube, Facebook, Instagram ve daha fazlası için yüksek kaliteli video indiriciler.',
        'video-downloader_h1' => 'Video İndirme Araçları',
    ],
    'zh' => [
        'video-downloader_title' => '视频下载工具',
        'video-downloader_subtitle' => '专业视频下载工具 - 100% 免费，无需注册',
        'video-downloader_meta_title' => '视频下载工具 - 免费在线视频下载器 | Optimizo',
        'video-downloader_meta_description' => '免费从各种平台下载视频。适用于 YouTube、Facebook、Instagram 等的高品质视频下载器。',
        'video-downloader_h1' => '视频下载工具',
    ],
];

foreach ($targetLanguages as $lang) {
    $filePath = "$basePath/$lang/categories.php";

    if (!file_exists($filePath)) {
        echo "[SKIP] $lang/categories.php - file not found\n";
        continue;
    }

    $existing = include $filePath;
    $keysToAdd = $translations[$lang];
    $added = [];

    foreach ($keysToAdd as $key => $value) {
        if (!array_key_exists($key, $existing)) {
            $existing[$key] = $value;
            $added[] = $key;
        }
    }

    if (empty($added)) {
        echo "[OK] $lang/categories.php - all keys already present\n";
        continue;
    }

    // Rebuild the file content
    $content = "<?php\n\nreturn [\n";
    foreach ($existing as $key => $value) {
        $escapedValue = str_replace("'", "\\'", $value);
        $content .= "    '$key' => '$escapedValue',\n";
    }
    $content .= "];\n";

    file_put_contents($filePath, $content);
    echo "[FIXED] $lang/categories.php - added " . count($added) . " keys: " . implode(', ', $added) . "\n";
}

echo "\nDone!\n";
