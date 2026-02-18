<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->string('flag_code', 2)->nullable()->after('flag_icon');
        });

        // Populate flag_code for existing languages
        $flagMap = [
            'en' => 'us',
            'es' => 'es',
            'fr' => 'fr',
            'de' => 'de',
            'it' => 'it',
            'pt' => 'pt',
            'ru' => 'ru',
            'tr' => 'tr',
            'ar' => 'sa',
            'hi' => 'in',
            'bn' => 'bd',
            'zh' => 'cn',
            'ja' => 'jp',
            'ko' => 'kr',
            'vi' => 'vn',
            'id' => 'id',
            'th' => 'th',
            'nl' => 'nl',
            'pl' => 'pl',
            'uk' => 'ua',
            'el' => 'gr',
            'fi' => 'fi',
            'no' => 'no',
            'cs' => 'cz',
            'sv' => 'se',
            'ro' => 'ro',
            'da' => 'dk',
        ];

        foreach ($flagMap as $langCode => $countryCode) {
            DB::table('languages')
                ->where('code', $langCode)
                ->update(['flag_code' => $countryCode]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->dropColumn('flag_code');
        });
    }
};
