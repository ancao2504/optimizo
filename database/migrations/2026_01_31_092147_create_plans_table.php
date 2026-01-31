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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // "Free", "Pro", "Enterprise"
            $table->string('slug')->unique();
            $table->decimal('price', 8, 2)->default(0);
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // List of features
            $table->json('tool_limits')->nullable(); // {"pdf_conversions": 10, "image_generations": 50}
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
