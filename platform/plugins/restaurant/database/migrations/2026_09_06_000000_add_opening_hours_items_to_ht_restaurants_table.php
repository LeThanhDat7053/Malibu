<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * opening_hours_items: danh sách khung giờ phục vụ (JSON), mỗi khung gồm tên,
 * giờ bắt đầu / kết thúc và ngày áp dụng. Cột opening_hours cũ giữ nguyên làm
 * dữ liệu dự phòng cho bản ghi chưa nhập khung giờ.
 */
return new class () extends Migration {
    public function up(): void
    {
        Schema::table('ht_restaurants', function (Blueprint $table): void {
            if (! Schema::hasColumn('ht_restaurants', 'opening_hours_items')) {
                $table->text('opening_hours_items')->nullable()->after('opening_hours');
            }
        });

        if (Schema::hasTable('ht_restaurants_translations')) {
            Schema::table('ht_restaurants_translations', function (Blueprint $table): void {
                if (! Schema::hasColumn('ht_restaurants_translations', 'opening_hours_items')) {
                    $table->text('opening_hours_items')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('ht_restaurants', function (Blueprint $table): void {
            $table->dropColumn('opening_hours_items');
        });

        if (Schema::hasTable('ht_restaurants_translations')) {
            Schema::table('ht_restaurants_translations', function (Blueprint $table): void {
                $table->dropColumn('opening_hours_items');
            });
        }
    }
};
