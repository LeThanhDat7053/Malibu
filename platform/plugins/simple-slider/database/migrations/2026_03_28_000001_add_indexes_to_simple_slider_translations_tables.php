<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('simple_sliders_translations')) {
            Schema::table('simple_sliders_translations', function (Blueprint $table): void {
                $table->index('simple_sliders_id', 'idx_simple_sliders_translations_slider');
                $table->index(['simple_sliders_id', 'lang_code'], 'idx_simple_sliders_translations_slider_lang');
            });
        }

        if (Schema::hasTable('simple_slider_items_translations')) {
            Schema::table('simple_slider_items_translations', function (Blueprint $table): void {
                $table->index('simple_slider_items_id', 'idx_simple_slider_items_translations_item');
                $table->index(['simple_slider_items_id', 'lang_code'], 'idx_simple_slider_items_translations_item_lang');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('simple_sliders_translations')) {
            Schema::table('simple_sliders_translations', function (Blueprint $table): void {
                $table->dropIndex('idx_simple_sliders_translations_slider');
                $table->dropIndex('idx_simple_sliders_translations_slider_lang');
            });
        }

        if (Schema::hasTable('simple_slider_items_translations')) {
            Schema::table('simple_slider_items_translations', function (Blueprint $table): void {
                $table->dropIndex('idx_simple_slider_items_translations_item');
                $table->dropIndex('idx_simple_slider_items_translations_item_lang');
            });
        }
    }
};
