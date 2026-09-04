<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        // Training context / glossary for AI translations
        Schema::create('ai_training_contexts', function (Blueprint $table) {
            $table->id();
            $table->string('source_language', 10)->default('en');
            $table->string('target_language', 10);
            $table->string('category', 100)->default('general'); // general, hotel, blog, etc.
            $table->string('source_term', 500)->nullable(); // specific term to translate
            $table->string('target_term', 500)->nullable(); // how it should be translated
            $table->text('context_instruction')->nullable(); // general instruction for AI
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['source_language', 'target_language', 'is_active'], 'idx_lang_pair_active');
            $table->index('category');
        });

        // Translation log for tracking usage
        Schema::create('ai_translation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('source_language', 10);
            $table->string('target_language', 10);
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('field_name', 100)->nullable();
            $table->unsignedInteger('input_tokens')->default(0);
            $table->unsignedInteger('output_tokens')->default(0);
            $table->string('ai_model', 50); // gpt-4o-mini etc.
            $table->decimal('estimated_cost', 10, 6)->default(0);
            $table->timestamps();

            $table->index(['created_at']);
            $table->index(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_translation_logs');
        Schema::dropIfExists('ai_training_contexts');
    }
};
