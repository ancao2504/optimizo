<?php

if (!function_exists('__tool')) {
    function __tool($slug, $key, $default = null)
    {
        $slugToCategory = [
            'angle-converter' => 'converters',
            'area-converter' => 'converters',
            'ascii-converter' => 'converters',
            'average-calculator' => 'calculators',
            'base64-encoder-decoder' => 'development',
            'base64-to-image-converter' => 'image',
            'binary-hex-converter' => 'converters',
            'binary-to-text' => 'converters',
            'bing-serp-checker' => 'seo',
            'bmi-calculator' => 'calculators',
            'broken-links-checker' => 'seo',
            'camel-case-converter' => 'converters',
            'case-converter' => 'converters',
            'code-formatter' => 'development',
            'compound-interest-calculator' => 'calculators',
            'cooking-unit-converter' => 'converters',
            'cron-job-generator' => 'development',
            'css-minifier' => 'development',
            'csv-to-excel' => 'spreadsheet',
            'csv-to-json' => 'spreadsheet',
            'csv-to-sql' => 'spreadsheet',
            'csv-to-tsv' => 'spreadsheet',
            'csv-to-xml-converter' => 'spreadsheet',
            'curl-command-builder' => 'development',
            'data-transfer-rate-converter' => 'converters',
            'date-to-unix-timestamp' => 'time',
            'decimal-binary-converter' => 'converters',
            'decimal-hex-converter' => 'converters',
            'decimal-octal-converter' => 'converters',
            'density-converter' => 'converters',
            'digital-storage-converter' => 'converters',
            'discount-calculator' => 'calculators',
            'dns-lookup' => 'network',
            'domain-to-ip' => 'network',
            'duplicate-line-remover' => 'text',
            'energy-converter' => 'converters',
            'epoch-time-converter' => 'time',
            'excel-to-csv' => 'spreadsheet',
            'excel-to-pdf' => 'document',
            'file-difference-checker' => 'text',
            'force-converter' => 'converters',
            'frequency-converter' => 'converters',
            'fuel-consumption-converter' => 'converters',
            'google-serp-checker' => 'seo',
            'google-index-checker' => 'seo',
            'gpa-calculator' => 'calculators',
            'google-allintitle-checker' => 'seo',
            'google-sheets-to-excel' => 'spreadsheet',
            'heic-to-jpg-converter' => 'image',
            'hreflang-checker' => 'seo',
            'html-encoder-decoder' => 'development',
            'html-minifier' => 'development',
            'html-to-markdown-converter' => 'development',
            'html-viewer' => 'development',
            'ico-converter' => 'image',
            'image-compressor' => 'image',
            'image-converter' => 'image',
            'image-to-base64-converter' => 'image',
            'internet-speed-test' => 'network',
            'ip-lookup' => 'network',
            'jpg-to-pdf' => 'document',
            'jpg-to-png-converter' => 'image',
            'jpg-to-webp-converter' => 'image',
            'js-minifier' => 'development',
            'json-formatter' => 'development',
            'json-parser' => 'development',
            'json-to-csv-converter' => 'development',
            'json-to-sql-converter' => 'development',
            'json-to-xml-converter' => 'development',
            'json-to-yaml-converter' => 'development',
            'jwt-decoder' => 'development',
            'kebab-case-converter' => 'converters',
            'keyword-density-checker' => 'seo',
            'length-converter' => 'converters',
            'local-time-to-utc' => 'time',
            'lorem-ipsum-generator' => 'text',
            'markdown-to-html-converter' => 'development',
            'md5-generator' => 'development',
            'adler32-hash-generator' => 'development',
            'crc32-hash-generator' => 'development',
            'crc32b-hash-generator' => 'development',
            'md4-hash-generator' => 'development',
            'sha1-hash-generator' => 'development',
            'sha256-hash-generator' => 'development',
            'sha384-hash-generator' => 'development',
            'sha512-hash-generator' => 'development',
            'ripemd128-hash-generator' => 'development',
            'ripemd160-hash-generator' => 'development',
            'tiger128-hash-generator' => 'development',
            'tiger160-hash-generator' => 'development',
            'tiger192-hash-generator' => 'development',
            'whirlpool-hash-generator' => 'development',
            'snefru-hash-generator' => 'development',
            'haval128-hash-generator' => 'development',
            'gost-hash-generator' => 'development',
            'htpasswd-generator' => 'development',
            'meta-tag-analyzer' => 'seo',
            'molar-mass-converter' => 'converters',
            'mortgage-calculator' => 'calculators',
            'morse-to-text-converter' => 'text',
            'number-base-converter' => 'converters',
            'on-page-seo-checker' => 'seo',
            'pascal-case-converter' => 'converters',
            'password-generator' => 'utility',
            'pdf-compressor' => 'document',
            'percentage-calculator' => 'calculators',
            'pdf-merger' => 'document',
            'pdf-splitter' => 'document',
            'pdf-to-excel' => 'document',
            'pdf-to-jpg' => 'document',
            'pdf-to-ppt' => 'document',
            'pdf-to-word' => 'document',
            'ping-test' => 'network',
            'png-to-jpg-converter' => 'image',
            'png-to-webp-converter' => 'image',
            'port-checker' => 'network',
            'power-converter' => 'converters',
            'ppt-to-pdf' => 'document',
            'pressure-converter' => 'converters',
            'qr-code-generator' => 'utility',
            'random-number-generator' => 'utility',
            'redirect-checker' => 'seo',
            'reverse-dns-lookup' => 'network',
            'rgb-hex-converter' => 'converters',
            'scientific-calculator' => 'calculators',
            'sentence-case-converter' => 'converters',
            'sitemap-validator' => 'seo',
            'slug-generator' => 'seo',
            'snake-case-converter' => 'converters',
            'speed-converter' => 'converters',
            'sql-to-json-converter' => 'development',
            'studly-case-converter' => 'converters',
            'svg-to-jpg-converter' => 'image',
            'svg-to-png-converter' => 'image',
            'temperature-converter' => 'converters',
            'text-reverser' => 'text',
            'text-to-binary' => 'converters',
            'text-to-morse-converter' => 'text',
            'text-to-speech' => 'youtube',
            'time-unit-converter' => 'time',
            'time-zone-converter' => 'time',
            'torque-converter' => 'converters',
            'traceroute' => 'network',
            'tsv-to-csv-converter' => 'spreadsheet',
            'unicode-encoder-decoder' => 'development',
            'unix-timestamp-to-date' => 'time',
            'url-encoder-decoder' => 'development',
            'user-agent-parser' => 'network',
            'username-checker' => 'utility',
            'utc-to-local-time' => 'time',
            'uuid-generator' => 'development',
            'volume-converter' => 'converters',
            'webp-to-jpg-converter' => 'image',
            'weight-converter' => 'converters',
            'what-is-my-ip' => 'network',
            'what-is-my-isp' => 'network',
            'whois-lookup' => 'network',
            'word-counter' => 'text',
            'word-to-pdf' => 'document',
            'xls-to-xlsx' => 'spreadsheet',
            'xlsx-to-xls' => 'spreadsheet',
            'xml-formatter' => 'development',
            'xml-to-csv' => 'development',
            'xml-to-json' => 'development',
            'yaml-to-json' => 'development',
            'regex-tester' => 'development',
            'json-validator' => 'development',
            'sql-formatter' => 'development',
            'yaml-formatter' => 'development',
            'diff-viewer' => 'development',
            'chmod-calculator' => 'development',
            'api-request-builder' => 'development',
            'color-palette-generator' => 'development',
            'svg-optimizer' => 'development',
            'javascript-obfuscator' => 'development',
            'css-flexbox-generator' => 'development',
            'css-grid-generator' => 'development',
            'css-gradient-generator' => 'development',
            'html-to-jsx-converter' => 'development',
            'csv-to-yaml-converter' => 'development',
            'toml-to-json-converter' => 'development',
            'json-to-toml-converter' => 'development',
            'yahoo-serp-checker' => 'seo',
            'youtube-channel-data-extractor' => 'youtube',
            'youtube-channel-id-finder' => 'youtube',
            'youtube-earnings-calculator' => 'youtube',
            'youtube-handle-checker' => 'youtube',
            'youtube-monetization-checker' => 'youtube',
            'youtube-tag-generator' => 'youtube',
            'youtube-thumbnail-downloader' => 'youtube',
            'youtube-video-data-extractor' => 'youtube',
            'youtube-video-tags-extractor' => 'youtube',
            'youtube-video-downloader' => 'downloader',
            'jpg-to-heic-converter' => 'image',
            'png-to-heic-converter' => 'image',
            'webp-to-png-converter' => 'image',
            'avif-to-jpg-converter' => 'image',
            'avif-to-png-converter' => 'image',
            'tiff-to-jpg-converter' => 'image',
            'bmp-to-jpg-converter' => 'image',
            'raw-to-jpg-converter' => 'image',
            'image-color-picker' => 'image',
            'image-color-replacer' => 'image',
            'grayscale-image-converter' => 'image',
            'black-and-white-image-converter' => 'image',
            'image-brightness-contrast-adjuster' => 'image',
            'image-sharpener' => 'image',
            'image-noise-reducer' => 'image',
            'image-metadata-viewer' => 'image',
            'image-metadata-remover' => 'image',
            'image-copyright-stamp' => 'image',
            'sprite-sheet-generator' => 'image',
            'image-lazy-load-generator' => 'image',
            'responsive-image-generator' => 'image',
        ];

        // Check for translation file in multiple locations (scalable strategy)
        static $translations = [];
        $locale = app()->getLocale();
        $category = $slugToCategory[$slug] ?? 'utility';

        $pathsToTry = [
            'nested' => base_path("resources/lang/$locale/tools/$category/$slug.json"),
            'tool' => base_path("resources/lang/$locale/tools/$slug.json"),
            'category' => base_path("resources/lang/$locale/tools/$category.json"),
        ];

        $foundPath = null;
        $strategy = null;

        if (file_exists($pathsToTry['nested'])) {
            $foundPath = $pathsToTry['nested'];
            $strategy = 'specific';
        } elseif (file_exists($pathsToTry['tool'])) {
            $foundPath = $pathsToTry['tool'];
            $strategy = 'specific';
        } elseif (file_exists($pathsToTry['category'])) {
            $foundPath = $pathsToTry['category'];
            $strategy = 'category';
        }

        $cacheKey = "$locale." . ($strategy === 'specific' ? "spec.$slug" : "cat.$category");

        if (!isset($translations[$cacheKey])) {
            if ($foundPath && file_exists($foundPath)) {
                $translations[$cacheKey] = json_decode(file_get_contents($foundPath), true) ?: [];
            } else {
                $translations[$cacheKey] = [];
            }
        }

        $data = $strategy === 'specific' ? $translations[$cacheKey] : ($translations[$cacheKey][$slug] ?? null);

        // Traverse the nested key
        if ($data !== null) {
            $keys = explode('.', $key);
            foreach ($keys as $k) {
                if (is_array($data) && isset($data[$k])) {
                    $data = $data[$k];
                } else {
                    $data = null;
                    break;
                }
            }
        }

        if ($data === null || (is_string($data) && strpos($data, '[Pending Translation') !== false)) {
            // Fallback to English if current locale is not English
            if ($locale !== 'en') {
                $enPathsToTry = [
                    'nested' => base_path("resources/lang/en/tools/$category/$slug.json"),
                    'tool' => base_path("resources/lang/en/tools/$slug.json"),
                    'category' => base_path("resources/lang/en/tools/$category.json"),
                ];

                $enFoundPath = null;
                $enStrategy = null;

                if (file_exists($enPathsToTry['nested'])) {
                    $enFoundPath = $enPathsToTry['nested'];
                    $enStrategy = 'specific';
                } elseif (file_exists($enPathsToTry['tool'])) {
                    $enFoundPath = $enPathsToTry['tool'];
                    $enStrategy = 'specific';
                } elseif (file_exists($enPathsToTry['category'])) {
                    $enFoundPath = $enPathsToTry['category'];
                    $enStrategy = 'category';
                }

                $enCacheKey = "en." . ($enStrategy === 'specific' ? "spec.$slug" : "cat.$category");

                if (!isset($translations[$enCacheKey])) {
                    if ($enFoundPath && file_exists($enFoundPath)) {
                        $translations[$enCacheKey] = json_decode(file_get_contents($enFoundPath), true) ?: [];
                    } else {
                        $translations[$enCacheKey] = [];
                    }
                }

                $enData = $enStrategy === 'specific' ? $translations[$enCacheKey] : ($translations[$enCacheKey][$slug] ?? null);
                if ($enData !== null) {
                    $keys = explode('.', $key);
                    foreach ($keys as $k) {
                        if (is_array($enData) && isset($enData[$k])) {
                            $enData = $enData[$k];
                        } else {
                            $enData = null;
                            break;
                        }
                    }
                }

                if ($enData !== null && !(is_string($enData) && strpos($enData, '[Pending Translation') !== false)) {
                    return $enData;
                }
            }

            return $default ?? "tools/$category.$slug.$key";
        }

        return $data;
    }
}

if (!function_exists('__t')) {
    function __t($tool, $key)
    {
        $slug = is_object($tool) ? $tool->slug : $tool;
        $map = [
            'name' => 'meta.title',
            'description' => 'meta.description',
            'h1' => 'meta.h1',
            'subtitle' => 'meta.subtitle',
        ];
        $targetKey = $map[$key] ?? $key;
        return __tool($slug, $targetKey);
    }
}

if (!function_exists('__page')) {
    function __page($page, $key, $default = null)
    {
        static $pageTranslations = [];
        $locale = app()->getLocale();
        $cacheKey = "$locale.pages";

        if (!isset($pageTranslations[$cacheKey])) {
            $jsonPath = base_path("resources/lang/$locale/pages.json");
            if (file_exists($jsonPath)) {
                $pageTranslations[$cacheKey] = json_decode(file_get_contents($jsonPath), true) ?: [];
            } else {
                $pageTranslations[$cacheKey] = [];
            }
        }

        $data = $pageTranslations[$cacheKey][$page] ?? null;

        if ($data !== null) {
            $keys = explode('.', $key);
            foreach ($keys as $k) {
                if (is_array($data) && isset($data[$k])) {
                    $data = $data[$k];
                } else {
                    $data = null;
                    break;
                }
            }
        }

        if ($data === null) {
            if ($locale !== 'en') {
                $enCacheKey = "en.pages";
                if (!isset($pageTranslations[$enCacheKey])) {
                    $enJsonPath = base_path("resources/lang/en/pages.json");
                    $pageTranslations[$enCacheKey] = file_exists($enJsonPath) ? json_decode(file_get_contents($enJsonPath), true) : [];
                }

                $enData = $pageTranslations[$enCacheKey][$page] ?? null;
                if ($enData !== null) {
                    $keys = explode('.', $key);
                    foreach ($keys as $k) {
                        if (is_array($enData) && isset($enData[$k])) {
                            $enData = $enData[$k];
                        } else {
                            $enData = null;
                            break;
                        }
                    }
                }

                if ($enData !== null) {
                    return $enData;
                }
            }

            return $default ?? "pages.$page.$key";
        }

        return $data;
    }
}