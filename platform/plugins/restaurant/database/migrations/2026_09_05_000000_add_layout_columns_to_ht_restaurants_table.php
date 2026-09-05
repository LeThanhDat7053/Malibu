<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Các cột phục vụ layout mới của trang nhà hàng:
 * - banner_image  : ảnh hero khổ lớn, tách khỏi gallery
 * - vr360_embed   : URL nhúng vào iframe để thay chỗ ảnh hero
 * - menu_images   : danh sách ảnh thực đơn (JSON), tách khỏi gallery
 * - subtitle      : dòng nhãn nhỏ phía trên tên nhà hàng
 * - menu_heading  : dòng phụ dưới chữ "Our Menu"
 *
 * Trên server các cột này được thêm bằng SQL chạy tay nên migration phải
 * kiểm tra trước để chạy lại được mà không lỗi.
 */
return new class () extends Migration {
    public function up(): void
    {
        Schema::table('ht_restaurants', function (Blueprint $table): void {
            if (! Schema::hasColumn('ht_restaurants', 'subtitle')) {
                $table->string('subtitle', 160)->nullable()->after('name');
            }

            if (! Schema::hasColumn('ht_restaurants', 'banner_image')) {
                $table->string('banner_image', 400)->nullable()->after('images');
            }

            if (! Schema::hasColumn('ht_restaurants', 'menu_images')) {
                $table->text('menu_images')->nullable()->after('banner_image');
            }

            if (! Schema::hasColumn('ht_restaurants', 'menu_heading')) {
                $table->string('menu_heading', 160)->nullable()->after('menu_images');
            }

            if (! Schema::hasColumn('ht_restaurants', 'vr360_embed')) {
                $table->string('vr360_embed', 500)->nullable()->after('vr360_url');
            }
        });

        if (Schema::hasTable('ht_restaurants_translations')) {
            Schema::table('ht_restaurants_translations', function (Blueprint $table): void {
                if (! Schema::hasColumn('ht_restaurants_translations', 'subtitle')) {
                    $table->string('subtitle', 160)->nullable();
                }

                if (! Schema::hasColumn('ht_restaurants_translations', 'menu_heading')) {
                    $table->string('menu_heading', 160)->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('ht_restaurants', function (Blueprint $table): void {
            $table->dropColumn(['subtitle', 'banner_image', 'menu_images', 'menu_heading', 'vr360_embed']);
        });
    }
};
