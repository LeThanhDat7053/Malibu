<?php

use Botble\SimpleSlider\Models\SimpleSlider;
use Botble\SimpleSlider\Models\SimpleSliderItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('simple_sliders_translations')) {
            Schema::create('simple_sliders_translations', function (Blueprint $table): void {
                $table->string('lang_code', 20);
                $table->foreignId('simple_sliders_id');
                $table->string('name', 120)->nullable();
                $table->string('description', 400)->nullable();

                $table->primary(['lang_code', 'simple_sliders_id'], 'simple_sliders_translations_primary');
            });
        }

        if (! Schema::hasTable('simple_slider_items_translations')) {
            Schema::create('simple_slider_items_translations', function (Blueprint $table): void {
                $table->string('lang_code', 20);
                $table->foreignId('simple_slider_items_id');
                $table->string('title')->nullable();
                $table->string('link')->nullable();
                $table->text('description')->nullable();

                $table->primary(['lang_code', 'simple_slider_items_id'], 'simple_slider_items_translations_primary');
            });
        }

        $this->seedDefaultTranslations();
        $this->migrateLegacyTranslations();
    }

    public function down(): void
    {
        Schema::dropIfExists('simple_slider_items_translations');
        Schema::dropIfExists('simple_sliders_translations');
    }

    protected function seedDefaultTranslations(): void
    {
        if (! Schema::hasTable('languages')) {
            return;
        }

        $languageCodes = DB::table('languages')
            ->where('lang_is_default', 0)
            ->pluck('lang_code')
            ->filter()
            ->all();

        if (! $languageCodes) {
            return;
        }

        DB::table('simple_sliders')
            ->orderBy('id')
            ->chunkById(100, function ($sliders) use ($languageCodes): void {
                $rows = [];

                foreach ($sliders as $slider) {
                    foreach ($languageCodes as $languageCode) {
                        $rows[] = [
                            'lang_code' => $languageCode,
                            'simple_sliders_id' => $slider->id,
                            'name' => $slider->name,
                            'description' => $slider->description,
                        ];
                    }
                }

                if ($rows) {
                    DB::table('simple_sliders_translations')->insertOrIgnore($rows);
                }
            });

        DB::table('simple_slider_items')
            ->orderBy('id')
            ->chunkById(100, function ($items) use ($languageCodes): void {
                $rows = [];

                foreach ($items as $item) {
                    foreach ($languageCodes as $languageCode) {
                        $rows[] = [
                            'lang_code' => $languageCode,
                            'simple_slider_items_id' => $item->id,
                            'title' => $item->title,
                            'link' => $item->link,
                            'description' => $item->description,
                        ];
                    }
                }

                if ($rows) {
                    DB::table('simple_slider_items_translations')->insertOrIgnore($rows);
                }
            });
    }

    protected function migrateLegacyTranslations(): void
    {
        if (! Schema::hasTable('language_meta') || ! Schema::hasTable('languages')) {
            return;
        }

        $defaultLanguageCode = DB::table('languages')
            ->where('lang_is_default', 1)
            ->value('lang_code');

        if (! $defaultLanguageCode) {
            return;
        }

        $this->migrateLegacySimpleSliders($defaultLanguageCode);
        $this->migrateLegacySimpleSliderItems($defaultLanguageCode);
    }

    protected function migrateLegacySimpleSliders(string $defaultLanguageCode): void
    {
        $defaultRecords = DB::table('language_meta')
            ->where('reference_type', SimpleSlider::class)
            ->where('lang_meta_code', $defaultLanguageCode)
            ->pluck('reference_id', 'lang_meta_origin');

        if ($defaultRecords->isEmpty()) {
            return;
        }

        DB::table('language_meta as lm')
            ->join('simple_sliders as ss', 'ss.id', '=', 'lm.reference_id')
            ->where('lm.reference_type', SimpleSlider::class)
            ->where('lm.lang_meta_code', '!=', $defaultLanguageCode)
            ->select([
                'lm.lang_meta_origin',
                'lm.lang_meta_code',
                'ss.name',
                'ss.description',
            ])
            ->orderBy('lm.lang_meta_id')
            ->chunk(100, function ($translations) use ($defaultRecords): void {
                foreach ($translations as $translation) {
                    $defaultId = $defaultRecords->get($translation->lang_meta_origin);

                    if (! $defaultId) {
                        continue;
                    }

                    DB::table('simple_sliders_translations')->updateOrInsert(
                        [
                            'lang_code' => $translation->lang_meta_code,
                            'simple_sliders_id' => $defaultId,
                        ],
                        [
                            'name' => $translation->name,
                            'description' => $translation->description,
                        ]
                    );
                }
            });
    }

    protected function migrateLegacySimpleSliderItems(string $defaultLanguageCode): void
    {
        $defaultRecords = DB::table('language_meta')
            ->where('reference_type', SimpleSliderItem::class)
            ->where('lang_meta_code', $defaultLanguageCode)
            ->pluck('reference_id', 'lang_meta_origin');

        if ($defaultRecords->isEmpty()) {
            return;
        }

        DB::table('language_meta as lm')
            ->join('simple_slider_items as ssi', 'ssi.id', '=', 'lm.reference_id')
            ->where('lm.reference_type', SimpleSliderItem::class)
            ->where('lm.lang_meta_code', '!=', $defaultLanguageCode)
            ->select([
                'lm.lang_meta_origin',
                'lm.lang_meta_code',
                'ssi.title',
                'ssi.link',
                'ssi.description',
            ])
            ->orderBy('lm.lang_meta_id')
            ->chunk(100, function ($translations) use ($defaultRecords): void {
                foreach ($translations as $translation) {
                    $defaultId = $defaultRecords->get($translation->lang_meta_origin);

                    if (! $defaultId) {
                        continue;
                    }

                    DB::table('simple_slider_items_translations')->updateOrInsert(
                        [
                            'lang_code' => $translation->lang_meta_code,
                            'simple_slider_items_id' => $defaultId,
                        ],
                        [
                            'title' => $translation->title,
                            'link' => $translation->link,
                            'description' => $translation->description,
                        ]
                    );
                }
            });
    }
};
