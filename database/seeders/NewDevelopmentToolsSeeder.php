<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tool;

class NewDevelopmentToolsSeeder extends Seeder
{
    public function run(): void
    {
        $categoryId = 9; // Development category
        $startOrder = 201;

        $tools = [
            [
                'name' => 'Regex Tester',
                'slug' => 'regex-tester',
                'icon_name' => 'fa-solid fa-magnifying-glass',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\RegexTesterController',
                'route_name' => 'development.regex-tester',
                'url' => '/tools/regex-tester',
            ],
            [
                'name' => 'JSON Validator',
                'slug' => 'json-validator',
                'icon_name' => 'fa-solid fa-check-circle',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\JsonValidatorController',
                'route_name' => 'development.json-validator',
                'url' => '/tools/json-validator',
            ],
            [
                'name' => 'CSS Gradient Generator',
                'slug' => 'css-gradient-generator',
                'icon_name' => 'fa-solid fa-palette',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\CssGradientGeneratorController',
                'route_name' => 'development.css-gradient-generator',
                'url' => '/tools/css-gradient-generator',
            ],
            [
                'name' => 'SQL Formatter',
                'slug' => 'sql-formatter',
                'icon_name' => 'fa-solid fa-database',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\SqlFormatterController',
                'route_name' => 'development.sql-formatter',
                'url' => '/tools/sql-formatter',
            ],
            [
                'name' => 'YAML Formatter',
                'slug' => 'yaml-formatter',
                'icon_name' => 'fa-solid fa-file-code',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\YamlFormatterController',
                'route_name' => 'development.yaml-formatter',
                'url' => '/tools/yaml-formatter',
            ],
            [
                'name' => 'HTML to JSX Converter',
                'slug' => 'html-to-jsx-converter',
                'icon_name' => 'fa-brands fa-react',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\HtmlToJsxConverterController',
                'route_name' => 'development.html-to-jsx-converter',
                'url' => '/tools/html-to-jsx-converter',
            ],
            [
                'name' => 'CSV to YAML Converter',
                'slug' => 'csv-to-yaml-converter',
                'icon_name' => 'fa-solid fa-file-csv',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\CsvToYamlConverterController',
                'route_name' => 'development.csv-to-yaml-converter',
                'url' => '/tools/csv-to-yaml-converter',
            ],
            [
                'name' => 'TOML to JSON Converter',
                'slug' => 'toml-to-json-converter',
                'icon_name' => 'fa-solid fa-file-import',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\TomlToJsonConverterController',
                'route_name' => 'development.toml-to-json-converter',
                'url' => '/tools/toml-to-json-converter',
            ],
            [
                'name' => 'JSON to TOML Converter',
                'slug' => 'json-to-toml-converter',
                'icon_name' => 'fa-solid fa-file-export',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\JsonToTomlConverterController',
                'route_name' => 'development.json-to-toml-converter',
                'url' => '/tools/json-to-toml-converter',
            ],
            [
                'name' => 'Diff Viewer',
                'slug' => 'diff-viewer',
                'icon_name' => 'fa-solid fa-code-compare',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\DiffViewerController',
                'route_name' => 'development.diff-viewer',
                'url' => '/tools/diff-viewer',
            ],
            [
                'name' => 'Chmod Calculator',
                'slug' => 'chmod-calculator',
                'icon_name' => 'fa-solid fa-lock',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\ChmodCalculatorController',
                'route_name' => 'development.chmod-calculator',
                'url' => '/tools/chmod-calculator',
            ],
            [
                'name' => 'API Request Builder',
                'slug' => 'api-request-builder',
                'icon_name' => 'fa-solid fa-paper-plane',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\ApiRequestBuilderController',
                'route_name' => 'development.api-request-builder',
                'url' => '/tools/api-request-builder',
            ],
            [
                'name' => 'Color Palette Generator',
                'slug' => 'color-palette-generator',
                'icon_name' => 'fa-solid fa-swatchbook',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\ColorPaletteGeneratorController',
                'route_name' => 'development.color-palette-generator',
                'url' => '/tools/color-palette-generator',
            ],
            [
                'name' => 'SVG Optimizer',
                'slug' => 'svg-optimizer',
                'icon_name' => 'fa-solid fa-vector-square',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\SvgOptimizerController',
                'route_name' => 'development.svg-optimizer',
                'url' => '/tools/svg-optimizer',
            ],
            [
                'name' => 'JavaScript Obfuscator',
                'slug' => 'javascript-obfuscator',
                'icon_name' => 'fa-solid fa-user-secret',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\JavascriptObfuscatorController',
                'route_name' => 'development.javascript-obfuscator',
                'url' => '/tools/javascript-obfuscator',
            ],
            [
                'name' => 'CSS Flexbox Generator',
                'slug' => 'css-flexbox-generator',
                'icon_name' => 'fa-solid fa-table-columns',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\CssFlexboxGeneratorController',
                'route_name' => 'development.css-flexbox-generator',
                'url' => '/tools/css-flexbox-generator',
            ],
            [
                'name' => 'CSS Grid Generator',
                'slug' => 'css-grid-generator',
                'icon_name' => 'fa-solid fa-table-cells',
                'controller' => 'App\\Http\\Controllers\\Tools\\Development\\CssGridGeneratorController',
                'route_name' => 'development.css-grid-generator',
                'url' => '/tools/css-grid-generator',
            ],
        ];

        foreach ($tools as $index => $toolData) {
            // Skip if already exists
            if (Tool::where('slug', $toolData['slug'])->exists()) {
                $this->command->line("Skipping (already exists): {$toolData['slug']}");
                continue;
            }

            Tool::create([
                'category_id' => $categoryId,
                'name' => $toolData['name'],
                'slug' => $toolData['slug'],
                'icon_name' => $toolData['icon_name'],
                'controller' => $toolData['controller'],
                'route_name' => $toolData['route_name'],
                'url' => $toolData['url'],
                'is_active' => true,
                'order' => $startOrder + $index,
            ]);

            $this->command->line("Created: {$toolData['slug']}");
        }

        $this->command->info('✅ All 17 new development tools seeded successfully!');
    }
}
