<?php

namespace Botble\Translation\Http\Controllers\Concerns;

use Botble\Base\Supports\Language;
use Botble\Translation\Tables\ThemeTranslationTable;
use Botble\Translation\Tables\TranslationTable;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait HasMapTranslationsTable
{
    protected function mapTranslationsTable(ThemeTranslationTable|TranslationTable $table, Request $request): array
    {
        // Use the languages DB table as the authoritative source so that
        // all configured languages appear even when lang/ folders are missing.
        $locales = static::getLocalesFromDb();
        $defaultLanguage = Language::getDefaultLanguage();

        if (! empty($locales)) {
            $defaultLocale = Arr::first($locales, fn ($item) => ! empty($item['is_default']));
            if ($defaultLocale) {
                $defaultLanguage = array_merge($defaultLanguage, [
                    'locale' => $defaultLocale['locale'],
                    'code'   => $defaultLocale['code'],
                    'name'   => $defaultLocale['name'],
                    'flag'   => $defaultLocale['flag'],
                    'is_rtl' => $defaultLocale['is_rtl'],
                ]);
            }
        } else {
            $locales = Language::getAvailableLocales();
        }

        if (! count($locales)) {
            $locales = [
                'en' => $defaultLanguage,
            ];
        }

        $currentLocale = $request->has('ref_lang') ? $request->input('ref_lang') : app()->getLocale();

        $group = Arr::first($locales, fn ($item) => $item['locale'] == $currentLocale);

        if (! $group) {
            $group = $defaultLanguage;
        }

        $table->setLocale($group['locale']);

        return [
            $locales,
            $group,
            $defaultLanguage,
            $table,
        ];
    }

    protected static function getLocalesFromDb(): array
    {
        try {
            if (! Schema::hasTable('languages')) {
                return [];
            }

            $rows = DB::table('languages')
                ->orderBy('lang_order')
                ->select(['lang_locale', 'lang_code', 'lang_name', 'lang_flag', 'lang_is_rtl', 'lang_is_default'])
                ->get();

            $locales = [];
            foreach ($rows as $row) {
                $locales[$row->lang_locale] = [
                    'locale'     => $row->lang_locale,
                    'code'       => $row->lang_code,
                    'name'       => $row->lang_name,
                    'flag'       => $row->lang_flag ?? $row->lang_locale,
                    'is_rtl'     => (bool) $row->lang_is_rtl,
                    'is_default' => (bool) $row->lang_is_default,
                ];
            }

            return $locales;
        } catch (\Throwable) {
            return [];
        }
    }
}
