<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Rename description to meta_description if it exists
        if (Schema::hasColumn('blog_categories', 'description')) {
            Schema::table('blog_categories', function (Blueprint $table) {
                $table->renameColumn('description', 'meta_description');
            });
        }

        // 2. Truncate and change type to VARCHAR(255)
        DB::statement('UPDATE blog_categories SET meta_description = SUBSTRING(meta_description, 1, 255)');
        DB::statement('ALTER TABLE blog_categories MODIFY meta_description VARCHAR(255) NULL');

        // 3. Add other columns
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('slug');
            $table->longText('content')->nullable()->after('meta_description');
        });
    }

    public function down(): void
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'content']);
            $table->renameColumn('meta_description', 'description');
        });

        DB::statement('ALTER TABLE blog_categories MODIFY description TEXT NULL');
    }
};
