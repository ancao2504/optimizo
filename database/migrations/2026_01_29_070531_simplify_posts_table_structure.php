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
        // 1. Initialize data (only if excerpt column exists)
        if (Schema::hasColumn('posts', 'excerpt')) {
            DB::table('posts')->update([
                'meta_title' => DB::raw('COALESCE(meta_title, title)'),
                'meta_description' => DB::raw('COALESCE(meta_description, excerpt)'),
            ]);

            // Truncate meta_description to avoid SQL errors on column type change
            DB::statement('UPDATE posts SET meta_description = SUBSTRING(meta_description, 1, 255)');
        }

        // 2. Drop columns if they exist
        Schema::table('posts', function (Blueprint $table) {
            $columnsToDrop = [
                'excerpt',
                'meta_keywords',
                'og_title',
                'og_description',
                'og_image',
                'twitter_title',
                'twitter_description',
                'twitter_image'
            ];

            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('posts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        // 3. Use raw SQL to change the column type to VARCHAR(255)
        DB::statement('ALTER TABLE posts MODIFY meta_description VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->text('excerpt')->nullable()->after('content');
            $table->string('meta_keywords')->nullable()->after('meta_description');
            $table->string('og_title')->nullable()->after('meta_keywords');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');
            $table->string('twitter_title')->nullable()->after('og_image');
            $table->text('twitter_description')->nullable()->after('twitter_title');
            $table->string('twitter_image')->nullable()->after('twitter_description');
        });

        DB::statement('ALTER TABLE posts MODIFY meta_description TEXT NULL');
    }
};
