<?php

namespace Botble\Product\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends BaseModel
{
    protected $table = 'ht_products';

    protected $fillable = [
        'name',
        'description',
        'content',
        'image',
        'images',
        'price',
        'original_price',
        'category_id',
        'total_sold',
        'is_featured',
        'enable_booking',
        'service_start_time',
        'service_end_time',
        'service_days',
        'time_slot_duration',
        'sale_start_date',
        'sale_end_date',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'price' => 'float',
        'original_price' => 'float',
        'total_sold' => 'integer',
        'enable_booking' => 'boolean',
        'service_days' => 'array',
        'time_slot_duration' => 'integer',
        'sale_start_date' => 'date',
        'sale_end_date' => 'date',
    ];

    public function getImagesAttribute($value = null)
    {
        if (func_num_args() === 0) {
            $translatedImages = null;

            if (
                ! $this->lang_code &&
                ! LanguageAdvancedManager::isDefaultLocale() &&
                $this->relationLoaded('translations')
            ) {
                $translatedImages = $this->translations
                    ->where('lang_code', LanguageAdvancedManager::getTranslationLocale())
                    ->value('images');
            }

            $decodedTranslatedImages = $this->decodeImages($translatedImages);

            if (! empty($decodedTranslatedImages)) {
                return $decodedTranslatedImages;
            }

            $value = $this->attributes['images'] ?? $this->getRawOriginal('images');
        }

        return $this->decodeImages($value);
    }

    public function setImagesAttribute($value): void
    {
        if (is_array($value)) {
            $value = array_values(array_filter($value));
            $this->attributes['images'] = json_encode($value);
        } else {
            $this->attributes['images'] = $value;
        }
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id')->withDefault();
    }

    protected function decodeImages($value): array
    {
        if ($value === '[null]' || $value === null || $value === '') {
            return [];
        }

        $images = json_decode((string) $value, true);

        if (is_array($images)) {
            $images = array_values(array_filter($images));
        }

        return $images ?: [];
    }

    /**
     * Check if the product is currently within its sale period.
     * Returns true if no sale dates are set (always available).
     */
    public function isWithinSalePeriod(): bool
    {
        $today = Carbon::today();

        if ($this->sale_start_date && $today->lt($this->sale_start_date)) {
            return false;
        }

        if ($this->sale_end_date && $today->gt($this->sale_end_date)) {
            return false;
        }

        return true;
    }
}
