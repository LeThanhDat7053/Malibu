<?php

namespace Botble\Hotel\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Hotel\Enums\ServicePriceTypeEnum;
use Botble\Language\Facades\Language;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Illuminate\Support\Facades\DB;

class Service extends BaseModel
{
    protected $table = 'ht_services';

    protected $fillable = [
        'name',
        'description',
        'content',
        'price',
        'price_type',
        'image',
        'status',
        'custom_url',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
        'description' => SafeContent::class,
        'content' => SafeContent::class,
        'price_type' => ServicePriceTypeEnum::class,
    ];

    public function getUrlAttribute(): string
    {
        if ($customUrl = $this->resolveCustomUrlForCurrentLocale()) {
            return $customUrl;
        }

        $slug = $this->slugable;

        if (! $slug || ! $slug->key) {
            return url('/');
        }

        $key = $slug->key;
        $prefix = $slug->prefix;

        if ($this->shouldUseTranslatedValueFallback()) {
            $translatedSlug = DB::table('slugs_translations')
                ->where('slugs_id', $slug->getKey())
                ->where('lang_code', Language::getCurrentLocaleCode())
                ->first(['key', 'prefix']);

            if (! empty($translatedSlug?->key)) {
                $key = $translatedSlug->key;
                $prefix = $translatedSlug->prefix ?: $prefix;
            }
        }

        $prefix = apply_filters(FILTER_SLUG_PREFIX, $prefix);

        return url(ltrim(($prefix ? $prefix . '/' : '') . $key, '/'));
    }

    protected function resolveCustomUrlForCurrentLocale(): ?string
    {
        if (! $this->shouldUseTranslatedValueFallback()) {
            return $this->getAttribute('custom_url') ?: null;
        }

        $this->loadMissing('translations');

        $translatedCustomUrl = $this->translations
            ->firstWhere('lang_code', Language::getCurrentLocaleCode())
            ?->custom_url;

        return filled($translatedCustomUrl) ? $translatedCustomUrl : null;
    }

    protected function shouldUseTranslatedValueFallback(): bool
    {
        return is_plugin_active('language')
            && is_plugin_active('language-advanced')
            && class_exists(LanguageAdvancedManager::class)
            && ! LanguageAdvancedManager::isDefaultLocale()
            && filled(Language::getCurrentLocaleCode());
    }
}
