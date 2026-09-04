<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('ai_translation_logs', function (Blueprint $table) {
            $table->string('api_key_hash', 16)->nullable()->after('estimated_cost');
            $table->index('api_key_hash');
        });
    }

    public function down(): void
    {
        Schema::table('ai_translation_logs', function (Blueprint $table) {
            $table->dropIndex(['api_key_hash']);
            $table->dropColumn('api_key_hash');
        });
    }
};
