<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Schema::hasTable('languages')) {
            // English (Default)
            DB::table('languages')->updateOrInsert(
                ['code' => 'en'],
                [
                    'name' => 'English',
                    'native_name' => 'English',
                    'flag_icon' => '🇺🇸',
                    'is_default' => true,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Russian
            DB::table('languages')->updateOrInsert(
                ['code' => 'ru'],
                [
                    'name' => 'Russian',
                    'native_name' => 'Русский',
                    'flag_icon' => '🇷🇺',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Spanish
            DB::table('languages')->updateOrInsert(
                ['code' => 'es'],
                [
                    'name' => 'Spanish',
                    'native_name' => 'Español',
                    'flag_icon' => '🇪🇸',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // French
            DB::table('languages')->updateOrInsert(
                ['code' => 'fr'],
                [
                    'name' => 'French',
                    'native_name' => 'Français',
                    'flag_icon' => '🇫🇷',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // German
            DB::table('languages')->updateOrInsert(
                ['code' => 'de'],
                [
                    'name' => 'German',
                    'native_name' => 'Deutsch',
                    'flag_icon' => '🇩🇪',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Italian
            DB::table('languages')->updateOrInsert(
                ['code' => 'it'],
                [
                    'name' => 'Italian',
                    'native_name' => 'Italiano',
                    'flag_icon' => '🇮🇹',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Portuguese
            DB::table('languages')->updateOrInsert(
                ['code' => 'pt'],
                [
                    'name' => 'Portuguese',
                    'native_name' => 'Português',
                    'flag_icon' => '🇵🇹',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Turkish
            DB::table('languages')->updateOrInsert(
                ['code' => 'tr'],
                [
                    'name' => 'Turkish',
                    'native_name' => 'Türkçe',
                    'flag_icon' => '🇹🇷',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Arabic
            DB::table('languages')->updateOrInsert(
                ['code' => 'ar'],
                [
                    'name' => 'Arabic',
                    'native_name' => 'العربية',
                    'flag_icon' => '🇸🇦',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'rtl'
                ]
            );

            // Chinese
            DB::table('languages')->updateOrInsert(
                ['code' => 'zh'],
                [
                    'name' => 'Chinese',
                    'native_name' => '中文',
                    'flag_icon' => '🇨🇳',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Japanese
            DB::table('languages')->updateOrInsert(
                ['code' => 'ja'],
                [
                    'name' => 'Japanese',
                    'native_name' => '日本語',
                    'flag_icon' => '🇯🇵',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Indonesian
            DB::table('languages')->updateOrInsert(
                ['code' => 'id'],
                [
                    'name' => 'Indonesian',
                    'native_name' => 'Bahasa Indonesia',
                    'flag_icon' => '🇮🇩',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Korean
            DB::table('languages')->updateOrInsert(
                ['code' => 'ko'],
                [
                    'name' => 'Korean',
                    'native_name' => '한국어',
                    'flag_icon' => '🇰🇷',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Finnish
            DB::table('languages')->updateOrInsert(
                ['code' => 'fi'],
                [
                    'name' => 'Finnish',
                    'native_name' => 'Suomi',
                    'flag_icon' => '🇫🇮',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Vietnamese
            DB::table('languages')->updateOrInsert(
                ['code' => 'vi'],
                [
                    'name' => 'Vietnamese',
                    'native_name' => 'Tiếng Việt',
                    'flag_icon' => '🇻🇳',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Dutch
            DB::table('languages')->updateOrInsert(
                ['code' => 'nl'],
                [
                    'name' => 'Dutch',
                    'native_name' => 'Nederlands',
                    'flag_icon' => '🇳🇱',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Polish
            DB::table('languages')->updateOrInsert(
                ['code' => 'pl'],
                [
                    'name' => 'Polish',
                    'native_name' => 'Polski',
                    'flag_icon' => '🇵🇱',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Norwegian
            DB::table('languages')->updateOrInsert(
                ['code' => 'no'],
                [
                    'name' => 'Norwegian',
                    'native_name' => 'Norsk',
                    'flag_icon' => '🇳🇴',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Czech
            DB::table('languages')->updateOrInsert(
                ['code' => 'cs'],
                [
                    'name' => 'Czech',
                    'native_name' => 'Čeština',
                    'flag_icon' => '🇨🇿',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Swedish
            DB::table('languages')->updateOrInsert(
                ['code' => 'sv'],
                [
                    'name' => 'Swedish',
                    'native_name' => 'Svenska',
                    'flag_icon' => '🇸🇪',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Romanian
            DB::table('languages')->updateOrInsert(
                ['code' => 'ro'],
                [
                    'name' => 'Romanian',
                    'native_name' => 'Română',
                    'flag_icon' => '🇷🇴',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Danish
            DB::table('languages')->updateOrInsert(
                ['code' => 'da'],
                [
                    'name' => 'Danish',
                    'native_name' => 'Dansk',
                    'flag_icon' => '🇩🇰',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );

            // Greek
            DB::table('languages')->updateOrInsert(
                ['code' => 'el'],
                [
                    'name' => 'Greek',
                    'native_name' => 'Ελληνικά',
                    'flag_icon' => '🇬🇷',
                    'is_default' => false,
                    'is_active' => true,
                    'direction' => 'ltr'
                ]
            );
        }
    }
}
