<?php

namespace Botble\AiTranslator\Providers;

use Botble\Base\Facades\Assets;
use Botble\Base\Supports\ServiceProvider;
use Botble\Language\Facades\Language;
use Botble\Language\Models\Language as LanguageModel;
use Illuminate\Support\Facades\Auth;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_action(BASE_ACTION_ENQUEUE_SCRIPTS, [$this, 'enqueueScripts'], 300);
    }

    public function enqueueScripts(): void
    {
        if (! Auth::check() || ! defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            return;
        }

        // Skip pages that don't need translation (settings, appearance, tools, etc.)
        $path = request()->path();
        $excludedPrefixes = [
            'admin/ai-translator',
            'admin/theme',
            'admin/menus',
            'admin/widgets',
            'admin/tools',
            'admin/translations',
            'admin/settings',
            'admin/system',
            'admin/plugins',
            'admin/media',
        ];

        foreach ($excludedPrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return;
            }
        }

        $languages = LanguageModel::query()
            ->select(['lang_id', 'lang_name', 'lang_code', 'lang_locale', 'lang_is_default'])
            ->orderBy('lang_order')
            ->get()
            ->toArray();

        if (count($languages) < 2) {
            return;
        }

        $apiKey = setting('ai_translator_api_key', config('plugins.ai-translator.general.openai_api_key'));
        $defaultLang = collect($languages)->firstWhere('lang_is_default', true);

        // Detect current editing language from ref_lang param
        $refLang = request()->input(Language::refLangKey());

        $config = json_encode([
            'translateUrl' => route('ai-translator.translate'),
            'batchTranslateUrl' => route('ai-translator.translate-batch'),
            'fetchOriginalUrl' => route('ai-translator.fetch-original'),
            'blogAutoTranslateUrl' => route('ai-translator.blog-auto-translate'),
            'modelAutoTranslateUrl' => route('ai-translator.model-auto-translate'),
            'settingsUrl' => route('ai-translator.settings'),
            'languages' => $languages,
            'defaultSourceLanguage' => $defaultLang['lang_code'] ?? 'en',
            'currentRefLang' => $refLang,
            'hasApiKey' => ! empty($apiKey),
        ], JSON_UNESCAPED_UNICODE);

        Assets::addScriptsDirectly('vendor/core/plugins/ai-translator/js/ai-translator.js');

        add_filter(BASE_FILTER_FOOTER_LAYOUT_TEMPLATE, function (?string $html) use ($config): ?string {
            return $html . "\n<script>window.aiTranslatorConfig = {$config};</script>";
        }, 300);
    }
}
