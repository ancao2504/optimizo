<?php

if (!function_exists('__tool')) {
    function __tool($slug, $key, $default = null)
    {
        $slugToCategory = [
            'angle-converter' => 'converters',
            'area-converter' => 'converters',
            'ascii-converter' => 'converters',
            'base64-encoder-decoder' => 'development',
            'base64-to-image-converter' => 'image',
            'binary-hex-converter' => 'converters',
            'binary-to-text' => 'converters',
            'bing-serp-checker' => 'seo',
            'broken-links-checker' => 'seo',
            'camel-case-converter' => 'converters',
            'case-converter' => 'converters',
            'code-formatter' => 'development',
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
            'meta-tag-analyzer' => 'seo',
            'molar-mass-converter' => 'converters',
            'morse-to-text-converter' => 'text',
            'number-base-converter' => 'converters',
            'on-page-seo-checker' => 'seo',
            'pascal-case-converter' => 'converters',
            'password-generator' => 'utility',
            'pdf-compressor' => 'document',
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
        ];

        // Check if a tool-specific JSON file exists (new scalable strategy)
        static $translations = [];
        $locale = app()->getLocale();

        $toolSpecificPath = base_path("resources/lang/$locale/tools/$slug.json");
        $isToolSpecific = file_exists($toolSpecificPath);

        if ($isToolSpecific) {
            $categoryFile = $slug;
            $cacheKey = "$locale.$categoryFile.specific";
        } else {
            $categoryFile = $slugToCategory[$slug] ?? 'utility';
            $cacheKey = "$locale.$categoryFile";
        }

        if (!isset($translations[$cacheKey])) {
            $jsonPath = $isToolSpecific ? $toolSpecificPath : base_path("resources/lang/$locale/tools/$categoryFile.json");
            if (file_exists($jsonPath)) {
                $translations[$cacheKey] = json_decode(file_get_contents($jsonPath), true) ?: [];
            } else {
                $translations[$cacheKey] = [];
            }
        }

        $data = $isToolSpecific ? $translations[$cacheKey] : ($translations[$cacheKey][$slug] ?? null);

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
                $enToolSpecificPath = base_path("resources/lang/en/tools/$slug.json");
                $isEnToolSpecific = file_exists($enToolSpecificPath);

                if ($isEnToolSpecific) {
                    $enCategoryFile = $slug;
                    $enCacheKey = "en.$enCategoryFile.specific";
                } else {
                    $enCategoryFile = $slugToCategory[$slug] ?? 'utility';
                    $enCacheKey = "en.$enCategoryFile";
                }

                if (!isset($translations[$enCacheKey])) {
                    $enJsonPath = $isEnToolSpecific ? $enToolSpecificPath : base_path("resources/lang/en/tools/$enCategoryFile.json");
                    $translations[$enCacheKey] = file_exists($enJsonPath) ? json_decode(file_get_contents($enJsonPath), true) : [];
                }

                $enData = $isEnToolSpecific ? $translations[$enCacheKey] : ($translations[$enCacheKey][$slug] ?? null);
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

            return $default ?? "tools/$categoryFile.$slug.$key";
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