<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        // Bảng có thể đã được tạo sẵn bằng file SQL chạy tay trên server,
        // nên kiểm tra trước để migration chạy lại được mà không lỗi.
        if (! Schema::hasTable('ht_restaurants')) {
            Schema::create('ht_restaurants', function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->longText('content')->nullable();
                $table->text('images')->nullable();
                $table->text('videos')->nullable();
                $table->string('vr360_url', 500)->nullable();
                $table->string('location', 120)->nullable();
                $table->string('capacity', 120)->nullable();
                $table->string('opening_hours', 160)->nullable();
                $table->string('cuisine', 120)->nullable();
                $table->string('phone', 60)->nullable();
                $table->string('email', 120)->nullable();
                $table->boolean('is_featured')->default(false);
                $table->integer('order')->default(0);
                $table->string('status', 60)->default('published')->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('ht_restaurants_translations')) {
            Schema::create('ht_restaurants_translations', function (Blueprint $table): void {
                $table->string('lang_code', 20);
                $table->foreignId('ht_restaurants_id');
                $table->string('name')->nullable();
                $table->text('description')->nullable();
                $table->longText('content')->nullable();
                $table->string('location', 120)->nullable();
                $table->string('capacity', 120)->nullable();
                $table->string('opening_hours', 160)->nullable();
                $table->string('cuisine', 120)->nullable();

                $table->primary(['lang_code', 'ht_restaurants_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ht_restaurants_translations');
        Schema::dropIfExists('ht_restaurants');
    }
};
