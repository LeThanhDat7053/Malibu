<?php

namespace Botble\AiTranslator\Http\Controllers;

use Botble\AiTranslator\Http\Requests\BatchTranslateRequest;
use Botble\AiTranslator\Http\Requests\TranslateRequest;
use Botble\AiTranslator\Models\AiTranslationLog;
use Botble\AiTranslator\Services\AiTranslatorService;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Models\BaseModel;
use Botble\Blog\Models\Post;
use Botble\Language\Facades\Language;
use Botble\Language\Models\LanguageMeta;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\Slug\Facades\SlugHelper;
use Botble\Setting\Facades\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AiTranslatorController extends BaseController
{
    public function __construct(protected AiTranslatorService $service)
    {
    }

    protected function shouldRetryPlainTextTranslation(?string $source, ?string $translated): bool
    {
        $source = is_string($source) ? trim($source) : '';
        $translated = is_string($translated) ? trim($translated) : '';

        if ($source === '') {
            return false;
        }

        if ($translated === '') {
            return true;
        }

        if (mb_strlen($source) < 10) {
            return false;
        }

        return mb_strtolower($source) === mb_strtolower($translated);
    }

    protected function translatePlainTextFieldWithRetry(
        array $translatedFields,
        array $fields,
        string $fieldName,
        string $targetLanguage,
        string $sourceLanguage,
        Post $post,
        ?string $fallback = null
    ): ?string {
        $sourceValue = $fields[$fieldName]['value'] ?? $fallback;
        $translatedValue = $translatedFields[$fieldName] ?? null;

        if ($this->shouldRetryPlainTextTranslation($sourceValue, $translatedValue)) {
            $retry = $this->service->translate(
                text: $sourceValue,
                targetLanguage: $targetLanguage,
                sourceLanguage: $sourceLanguage,
                fieldType: 'text',
                category: 'blog',
                modelType: Post::class,
                modelId: $post->getKey(),
                fieldName: $fieldName,
            );

            if ($retry['success'] && filled($retry['translated'] ?? null)) {
                return $retry['translated'];
            }
        }

        return $translatedValue ?: $sourceValue ?: $fallback;
    }

    /**
     * Translate a single field.
     */
    public function translate(TranslateRequest $request, BaseHttpResponse $response)
    {
        $result = $this->service->translate(
            text: $request->input('text'),
            targetLanguage: $request->input('target_language'),
            sourceLanguage: $request->input('source_language', 'en'),
            fieldType: $request->input('field_type', 'text'),
            category: $request->input('category', 'general'),
            modelType: $request->input('model_type'),
            modelId: $request->input('model_id'),
            fieldName: $request->input('field_name'),
        );

        if (! $result['success']) {
            return $response->setError()->setMessage($result['error']);
        }

        return $response
            ->setData([
                'translated' => $result['translated'],
                'tokens' => $result['tokens'] ?? null,
                'cost' => $result['cost'] ?? 0,
            ])
            ->setMessage('Translation completed successfully.');
    }

    /**
     * Translate multiple fields at once.
     */
    public function translateBatch(BatchTranslateRequest $request, BaseHttpResponse $response)
    {
        $result = $this->service->translateBatch(
            fields: $request->input('fields'),
            targetLanguage: $request->input('target_language'),
            sourceLanguage: $request->input('source_language', 'en'),
            category: $request->input('category', 'general'),
            modelType: $request->input('model_type'),
            modelId: $request->input('model_id'),
        );

        if (! $result['success']) {
            return $response->setError()->setMessage($result['error']);
        }

        return $response
            ->setData([
                'translations' => $result['translations'],
                'tokens' => $result['tokens'] ?? null,
                'cost' => $result['cost'] ?? 0,
            ])
            ->setMessage('Batch translation completed.');
    }

    /**
     * Settings page.
     */
    public function settings(Request $request)
    {
        // Handle reset via GET param (avoids 401 issues with POST)
        if ($request->input('reset_usage') === '1') {
            if ($this->service->hasApiKeyHashColumn()) {
                $hash = $this->service->getApiKeyHash();
                if ($hash) {
                    AiTranslationLog::where('api_key_hash', $hash)->delete();
                } else {
                    AiTranslationLog::whereNull('api_key_hash')
                        ->orWhere('api_key_hash', '')
                        ->delete();
                }
            } else {
                AiTranslationLog::where('created_at', '>=', now()->startOfMonth())->delete();
            }

            return redirect()->route('ai-translator.settings')
                ->with('success', 'Usage statistics have been reset.');
        }

        page_title()->setTitle('AI Translator Settings');

        $stats = $this->service->getUsageStats('month');
        $stats['source'] = 'local';

        return view('plugins/ai-translator::settings', compact('stats'));
    }

    /**
     * Save settings.
     */
    public function saveSettings(Request $request, BaseHttpResponse $response)
    {
        $data = [
            'ai_translator_api_key' => $request->input(
                'ai_translator_api_key',
                (string) setting('ai_translator_api_key', '')
            ),
            'ai_translator_model' => $request->input(
                'ai_translator_model',
                (string) setting('ai_translator_model', 'gpt-4o-mini')
            ),
            'ai_translator_prompt' => $request->exists('ai_translator_prompt')
                ? $request->input('ai_translator_prompt')
                : (string) setting('ai_translator_prompt', ''),
        ];

        $validated = validator($data, [
            'ai_translator_api_key' => ['nullable', 'string', 'max:255'],
            'ai_translator_model' => ['required', 'string', 'in:gpt-4.1-nano,gpt-4o-mini,gpt-4.1-mini,gpt-4.1,gpt-4o,gpt-4.5-preview,o4-mini,o3-mini,o3,o1,o1-mini,gpt-4-turbo,gpt-4,gpt-3.5-turbo'],
            'ai_translator_prompt' => ['nullable', 'string', 'max:5000'],
        ])->validate();

        Setting::set('ai_translator_api_key', $validated['ai_translator_api_key'] ?? '');
        Setting::set('ai_translator_model', $validated['ai_translator_model']);
        Setting::set('ai_translator_prompt', $validated['ai_translator_prompt'] ?? '');
        Setting::save();

        return $response->setMessage('Settings saved successfully.');
    }

    /**
     * Test API connection.
     */
    public function testConnection(BaseHttpResponse $response)
    {
        $result = $this->service->testConnection();

        if (! $result['success']) {
            return $response->setError()->setMessage($result['error']);
        }

        return $response->setMessage($result['message']);
    }

    /**
     * Get usage statistics.
     */
    public function usageStats(Request $request, BaseHttpResponse $response)
    {
        $period = $request->input('period', 'month');
        $stats = $this->service->getUsageStats($period);

        return $response->setData($stats);
    }

    /**
     * Reset usage statistics for the current API key.
     */
    public function resetUsage(BaseHttpResponse $response)
    {
        if ($this->service->hasApiKeyHashColumn()) {
            $hash = $this->service->getApiKeyHash();

            if ($hash) {
                AiTranslationLog::where('api_key_hash', $hash)->delete();
            } else {
                AiTranslationLog::whereNull('api_key_hash')
                    ->orWhere('api_key_hash', '')
                    ->delete();
            }
        } else {
            // Column not yet migrated — clear all logs for this month
            AiTranslationLog::where('created_at', '>=', now()->startOfMonth())->delete();
        }

        return $response->setMessage('Usage statistics have been reset.');
    }

    /**
     * Get available languages from existing language plugin.
     */
    public function getLanguages(BaseHttpResponse $response)
    {
        $languages = [];

        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            $languages = \Botble\Language\Models\Language::query()
                ->select(['lang_id', 'lang_name', 'lang_code', 'lang_locale', 'lang_is_default'])
                ->orderBy('lang_order')
                ->get()
                ->toArray();
        }

        return $response->setData($languages);
    }

    /**
     * Fetch original content from a model for translation.
     * Used when editing a translation page (?ref_lang=xx) to get the source text.
     */
    public function fetchOriginal(Request $request, BaseHttpResponse $response)
    {
        $request->validate([
            'model_type' => ['required', 'string', 'max:255'],
            'model_id' => ['required', 'integer'],
            'fields' => ['required', 'array'],
            'fields.*' => ['string', 'max:100'],
        ]);

        $modelClass = $request->input('model_type');
        $modelId = $request->input('model_id');
        $fields = $request->input('fields');

        // Security: only allow known model classes
        if (! class_exists($modelClass) || ! is_subclass_of($modelClass, \Botble\Base\Models\BaseModel::class)) {
            return $response->setError()->setMessage('Invalid model type.');
        }

        $model = $modelClass::find($modelId);
        if (! $model) {
            return $response->setError()->setMessage('Model not found.');
        }

        $data = [];
        foreach ($fields as $field) {
            // Only allow reading translatable fields
            if (preg_match('/^[a-z_]+$/', $field)) {
                $data[$field] = $model->getRawOriginal($field) ?? ($model->{$field} ?? '');
            }
        }

        return $response->setData($data);
    }

    /**
     * Translate a blog post into all active languages and persist results.
     */
    public function translateBlogPostAll(Request $request, BaseHttpResponse $response)
    {
        try {
            if (! is_plugin_active('blog')) {
                return $response->setError()->setMessage('Blog plugin is not enabled.');
            }

            $validated = $request->validate([
                'post_id' => ['required', 'integer', 'exists:posts,id'],
                'languages' => ['nullable', 'array'],
                'languages.*' => ['string'],
            ]);

            $post = Post::query()
                ->with(['categories:id', 'tags:id,name', 'slugable'])
                ->find($validated['post_id']);

            if (! $post) {
                return $response->setError()->setMessage('Post not found.');
            }

            $defaultLanguage = Language::getDefaultLanguage(['lang_code', 'lang_name']);

            if (! $defaultLanguage) {
                return $response->setError()->setMessage('No default language configured.');
            }

            $languages = collect(Language::getActiveLanguage(['lang_code', 'lang_name', 'lang_is_default']));
            $targetCodes = $validated['languages'] ?? $languages->pluck('lang_code')->all();

            $targets = $languages
                ->where('lang_is_default', false)
                ->whereIn('lang_code', $targetCodes)
                ->values();

            if ($targets->isEmpty()) {
                return $response->setError()->setMessage('No target languages to translate.');
            }

            $fields = $request->input('fields');

            if (! is_array($fields) || empty($fields)) {
                $fields = [
                    'name' => ['value' => $post->getRawOriginal('name') ?? $post->name, 'type' => 'text'],
                    'description' => ['value' => $post->getRawOriginal('description') ?? $post->description, 'type' => 'text'],
                    'content' => ['value' => $post->getRawOriginal('content') ?? $post->content, 'type' => 'html'],
                ];
            }

            $allowedFields = ['name', 'title', 'description', 'content', 'custom_html'];
            $fields = collect($fields)
                ->only($allowedFields)
                ->map(function ($field, $key) {
                    if (is_array($field) && isset($field['value'])) {
                        return [
                            'value' => (string) $field['value'],
                            'type' => in_array($key, ['content', 'custom_html']) ? 'html' : 'text',
                        ];
                    }

                    return null;
                })
                ->filter()
                ->toArray();

            if (empty($fields)) {
                return $response->setError()->setMessage('No translatable blog content was found.');
            }

            $results = [];
            $usesLanguageAdvanced = is_plugin_active('language-advanced')
                && config('plugins.blog.general.use_language_v2')
                && LanguageAdvancedManager::isSupported(Post::class);

            foreach ($targets as $language) {
                $translation = $this->service->translateBatch(
                    fields: $fields,
                    targetLanguage: $language->lang_code,
                    sourceLanguage: $defaultLanguage->lang_code,
                    category: 'blog',
                    modelType: Post::class,
                    modelId: $post->getKey()
                );

                if (! $translation['success']) {
                    $results[] = [
                        'lang_code' => $language->lang_code,
                        'language' => $language->lang_name,
                        'success' => false,
                        'message' => $translation['error'] ?? 'Translation failed.',
                    ];

                    continue;
                }

                $translatedFields = $translation['translations'] ?? [];
                $translatedName = $this->translatePlainTextFieldWithRetry(
                    translatedFields: $translatedFields,
                    fields: $fields,
                    fieldName: 'name',
                    targetLanguage: $language->lang_code,
                    sourceLanguage: $defaultLanguage->lang_code,
                    post: $post,
                    fallback: $post->name
                );
                $translatedDescription = $this->translatePlainTextFieldWithRetry(
                    translatedFields: $translatedFields,
                    fields: $fields,
                    fieldName: 'description',
                    targetLanguage: $language->lang_code,
                    sourceLanguage: $defaultLanguage->lang_code,
                    post: $post,
                    fallback: $post->description
                );
                $translatedContent = $translatedFields['content'] ?? ($fields['content']['value'] ?? $post->content);

                try {
                    DB::beginTransaction();

                    if ($usesLanguageAdvanced) {
                        $condition = [
                            'lang_code' => $language->lang_code,
                            'posts_id' => $post->getKey(),
                        ];

                        $translationData = [
                            'name' => $translatedName,
                            'description' => $translatedDescription,
                            'content' => $translatedContent,
                        ];

                        $created = ! DB::table('posts_translations')->where($condition)->exists();

                        DB::table('posts_translations')->updateOrInsert($condition, $translationData + $condition);

                        if ($post->slugable) {
                            $slugCondition = [
                                'lang_code' => $language->lang_code,
                                'slugs_id' => $post->slugable->getKey(),
                            ];

                            DB::table('slugs_translations')->updateOrInsert($slugCondition, [
                                'key' => Str::slug($translatedName),
                                'prefix' => $post->slugable->prefix ?: SlugHelper::getPrefix(Post::class),
                            ] + $slugCondition);
                        }
                    } else {
                        $origin = LanguageMeta::query()
                            ->where([
                                'reference_id' => $post->getKey(),
                                'reference_type' => Post::class,
                            ])
                            ->value('lang_meta_origin');

                        if (! $origin) {
                            LanguageMeta::saveMetaData($post, $defaultLanguage->lang_code);
                            $origin = LanguageMeta::query()
                                ->where([
                                    'reference_id' => $post->getKey(),
                                    'reference_type' => Post::class,
                                ])
                                ->value('lang_meta_origin');
                        }

                        if (! $origin) {
                            throw new \RuntimeException('Unable to determine the language origin for this post.');
                        }

                        $meta = LanguageMeta::query()
                            ->where([
                                'lang_meta_origin' => $origin,
                                'lang_meta_code' => $language->lang_code,
                                'reference_type' => Post::class,
                            ])
                            ->first();

                        $created = false;
                        $targetPost = $meta ? Post::query()->find($meta->reference_id) : null;

                        if ($targetPost) {
                            $targetPost->fill([
                                'name' => $translatedName,
                                'description' => $translatedDescription,
                                'content' => $translatedContent,
                            ]);

                            $targetPost->save();
                        } else {
                            $targetPost = $post->replicate();
                            $targetPost->name = $translatedName;
                            $targetPost->description = $translatedDescription;
                            $targetPost->content = $translatedContent;
                            $targetPost->created_at = $post->created_at;
                            $targetPost->save();

                            $targetPost->categories()->sync($post->categories->pluck('id')->all());
                            $targetPost->tags()->sync($post->tags->pluck('id')->all());

                            $created = true;
                        }

                        LanguageMeta::query()->updateOrCreate(
                            [
                                'reference_id' => $targetPost->getKey(),
                                'reference_type' => Post::class,
                            ],
                            [
                                'lang_meta_code' => $language->lang_code,
                                'lang_meta_origin' => $origin,
                            ]
                        );

                        if ($created) {
                            SlugHelper::createSlug($targetPost, $translatedName);
                        }
                    }

                    DB::commit();
                } catch (\Throwable $e) {
                    DB::rollBack();

                    Log::error('AI blog auto translate save failed', [
                        'post_id' => $post->getKey(),
                        'target_language' => $language->lang_code,
                        'message' => $e->getMessage(),
                    ]);

                    $results[] = [
                        'lang_code' => $language->lang_code,
                        'language' => $language->lang_name,
                        'success' => false,
                        'message' => 'Failed to save translated blog content.',
                    ];

                    continue;
                }

                $results[] = [
                    'lang_code' => $language->lang_code,
                    'language' => $language->lang_name,
                    'success' => true,
                    'created' => $created,
                    'post_id' => $post->getKey(),
                    'edit_url' => route('posts.edit', $post->getKey()) . '?ref_lang=' . $language->lang_code,
                    'cost' => $translation['cost'] ?? 0,
                ];
            }

            return $response
                ->setData(['results' => $results])
                ->setMessage('Blog translations completed.');
        } catch (\Throwable $e) {
            Log::error('AI blog auto translate failed', [
                'post_id' => $request->input('post_id'),
                'languages' => $request->input('languages', []),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $response
                ->setError()
                ->setMessage('Blog auto-translate failed: ' . $e->getMessage());
        }
    }

    /**
     * Get translation configuration for supported models.
     */
    protected function getModelTranslationConfigs(): array
    {
        return [
            \Botble\Hotel\Models\Room::class => [
                'translationTable' => 'ht_rooms_translations',
                'translationFk' => 'ht_rooms_id',
                'fields' => ['name' => 'text', 'description' => 'text', 'content' => 'html'],
                'category' => 'hotel',
                'editRoute' => 'room.edit',
                'pluginCheck' => 'hotel',
                'hasSlug' => true,
            ],
            \Botble\Hotel\Models\Amenity::class => [
                'translationTable' => 'ht_amenities_translations',
                'translationFk' => 'ht_amenities_id',
                'fields' => ['name' => 'text', 'description' => 'text'],
                'category' => 'hotel',
                'editRoute' => 'amenity.edit',
                'pluginCheck' => 'hotel',
                'hasSlug' => false,
            ],
            \Botble\Hotel\Models\Service::class => [
                'translationTable' => 'ht_services_translations',
                'translationFk' => 'ht_services_id',
                'fields' => ['name' => 'text', 'description' => 'text', 'content' => 'html'],
                'category' => 'hotel',
                'editRoute' => 'service.edit',
                'pluginCheck' => 'hotel',
                'hasSlug' => true,
            ],
            \Botble\Page\Models\Page::class => [
                'translationTable' => 'pages_translations',
                'translationFk' => 'pages_id',
                'fields' => ['name' => 'text', 'description' => 'text', 'content' => 'html', 'custom_html' => 'html'],
                'category' => 'page',
                'editRoute' => 'pages.edit',
                'pluginCheck' => null,
                'hasSlug' => true,
            ],
            \Botble\Gallery\Models\Gallery::class => [
                'translationTable' => 'galleries_translations',
                'translationFk' => 'galleries_id',
                'fields' => ['name' => 'text', 'description' => 'text'],
                'category' => 'gallery',
                'editRoute' => 'galleries.edit',
                'pluginCheck' => 'gallery',
                'hasSlug' => true,
            ],
            \Botble\Product\Models\Product::class => [
                'translationTable' => 'ht_products_translations',
                'translationFk' => 'ht_products_id',
                'fields' => ['name' => 'text', 'description' => 'text', 'content' => 'html'],
                'category' => 'product',
                'editRoute' => 'product.edit',
                'pluginCheck' => 'product',
                'hasSlug' => true,
            ],
        ];
    }

    /**
     * Retry plain-text translation for any model (generic version).
     */
    protected function retryPlainTextField(
        array $translatedFields,
        array $fields,
        string $fieldName,
        string $targetLanguage,
        string $sourceLanguage,
        string $modelClass,
        int|string $modelId,
        ?string $fallback = null
    ): ?string {
        $sourceValue = $fields[$fieldName]['value'] ?? $fallback;
        $translatedValue = $translatedFields[$fieldName] ?? null;

        if ($this->shouldRetryPlainTextTranslation($sourceValue, $translatedValue)) {
            $retry = $this->service->translate(
                text: $sourceValue,
                targetLanguage: $targetLanguage,
                sourceLanguage: $sourceLanguage,
                fieldType: 'text',
                category: 'general',
                modelType: $modelClass,
                modelId: $modelId,
                fieldName: $fieldName,
            );

            if ($retry['success'] && filled($retry['translated'] ?? null)) {
                return $retry['translated'];
            }
        }

        return $translatedValue ?: $sourceValue ?: $fallback;
    }

    /**
     * Translate any supported model into all active languages and persist results.
     * Supports: Room, Amenity, Service, Page, Gallery, Product.
     */
    public function translateModelAll(Request $request, BaseHttpResponse $response)
    {
        try {
            $validated = $request->validate([
                'model_type' => ['required', 'string', 'max:255'],
                'model_id' => ['required', 'integer'],
                'languages' => ['nullable', 'array'],
                'languages.*' => ['string'],
                'fields' => ['nullable', 'array'],
            ]);

            $modelClass = $validated['model_type'];
            $configs = $this->getModelTranslationConfigs();

            if (! isset($configs[$modelClass])) {
                return $response->setError()->setMessage('Unsupported model type.');
            }

            $config = $configs[$modelClass];

            if ($config['pluginCheck'] && ! is_plugin_active($config['pluginCheck'])) {
                return $response->setError()->setMessage('Required plugin is not enabled.');
            }

            if (! class_exists($modelClass)) {
                return $response->setError()->setMessage('Model class not found.');
            }

            $model = $modelClass::query();

            // Load slugable relation if model has slug
            if ($config['hasSlug']) {
                $model = $model->with('slugable');
            }

            $model = $model->find($validated['model_id']);

            if (! $model) {
                return $response->setError()->setMessage('Record not found.');
            }

            $defaultLanguage = Language::getDefaultLanguage(['lang_code', 'lang_name']);

            if (! $defaultLanguage) {
                return $response->setError()->setMessage('No default language configured.');
            }

            $languages = collect(Language::getActiveLanguage(['lang_code', 'lang_name', 'lang_is_default']));
            $targetCodes = $validated['languages'] ?? $languages->pluck('lang_code')->all();

            $targets = $languages
                ->where('lang_is_default', false)
                ->whereIn('lang_code', $targetCodes)
                ->values();

            if ($targets->isEmpty()) {
                return $response->setError()->setMessage('No target languages to translate.');
            }

            // Build fields from model if not provided
            $fields = $request->input('fields');

            if (! is_array($fields) || empty($fields)) {
                $fields = [];
                foreach ($config['fields'] as $fieldName => $fieldType) {
                    $value = $model->getRawOriginal($fieldName) ?? ($model->{$fieldName} ?? '');
                    if ($value !== null && $value !== '') {
                        $fields[$fieldName] = ['value' => (string) $value, 'type' => $fieldType];
                    }
                }
            }

            // Filter and validate fields
            $allowedFields = array_keys($config['fields']);
            $fields = collect($fields)
                ->only($allowedFields)
                ->map(function ($field, $key) use ($config) {
                    if (is_array($field) && isset($field['value'])) {
                        return [
                            'value' => (string) $field['value'],
                            'type' => $config['fields'][$key] ?? 'text',
                        ];
                    }

                    return null;
                })
                ->filter()
                ->toArray();

            // Merge any missing config fields from model data (ensures description etc. is always included)
            foreach ($config['fields'] as $fieldName => $fieldType) {
                if (! isset($fields[$fieldName])) {
                    $value = $model->getRawOriginal($fieldName) ?? ($model->{$fieldName} ?? '');
                    if ($value !== null && $value !== '') {
                        $fields[$fieldName] = ['value' => (string) $value, 'type' => $fieldType];
                    }
                }
            }

            if (empty($fields)) {
                return $response->setError()->setMessage('No translatable content was found.');
            }

            $results = [];
            $usesLanguageAdvanced = is_plugin_active('language-advanced')
                && LanguageAdvancedManager::isSupported($modelClass);

            foreach ($targets as $language) {
                $translation = $this->service->translateBatch(
                    fields: $fields,
                    targetLanguage: $language->lang_code,
                    sourceLanguage: $defaultLanguage->lang_code,
                    category: $config['category'],
                    modelType: $modelClass,
                    modelId: $model->getKey()
                );

                if (! $translation['success']) {
                    $results[] = [
                        'lang_code' => $language->lang_code,
                        'language' => $language->lang_name,
                        'success' => false,
                        'message' => $translation['error'] ?? 'Translation failed.',
                    ];

                    continue;
                }

                $translatedFields = $translation['translations'] ?? [];

                // Retry plain text fields that may not have been translated properly
                $translatedData = [];
                foreach ($config['fields'] as $fieldName => $fieldType) {
                    if (! isset($fields[$fieldName])) {
                        continue;
                    }

                    if ($fieldType === 'text') {
                        $translatedData[$fieldName] = $this->retryPlainTextField(
                            translatedFields: $translatedFields,
                            fields: $fields,
                            fieldName: $fieldName,
                            targetLanguage: $language->lang_code,
                            sourceLanguage: $defaultLanguage->lang_code,
                            modelClass: $modelClass,
                            modelId: $model->getKey(),
                            fallback: $model->{$fieldName}
                        );
                    } else {
                        $translatedData[$fieldName] = $translatedFields[$fieldName]
                            ?? ($fields[$fieldName]['value'] ?? $model->{$fieldName});
                    }
                }

                try {
                    DB::beginTransaction();

                    $created = false;

                    if ($usesLanguageAdvanced) {
                        $condition = [
                            'lang_code' => $language->lang_code,
                            $config['translationFk'] => $model->getKey(),
                        ];

                        $created = ! DB::table($config['translationTable'])->where($condition)->exists();

                        DB::table($config['translationTable'])->updateOrInsert(
                            $condition,
                            $translatedData + $condition
                        );

                        // Handle slug translation
                        if ($config['hasSlug'] && $model->slugable && isset($translatedData['name'])) {
                            $slugCondition = [
                                'lang_code' => $language->lang_code,
                                'slugs_id' => $model->slugable->getKey(),
                            ];

                            DB::table('slugs_translations')->updateOrInsert($slugCondition, [
                                'key' => Str::slug($translatedData['name']),
                                'prefix' => $model->slugable->prefix ?: SlugHelper::getPrefix($modelClass),
                            ] + $slugCondition);
                        }
                    } else {
                        // Language v1: model duplication strategy
                        $origin = LanguageMeta::query()
                            ->where([
                                'reference_id' => $model->getKey(),
                                'reference_type' => $modelClass,
                            ])
                            ->value('lang_meta_origin');

                        if (! $origin) {
                            LanguageMeta::saveMetaData($model, $defaultLanguage->lang_code);
                            $origin = LanguageMeta::query()
                                ->where([
                                    'reference_id' => $model->getKey(),
                                    'reference_type' => $modelClass,
                                ])
                                ->value('lang_meta_origin');
                        }

                        if (! $origin) {
                            throw new \RuntimeException('Unable to determine the language origin for this record.');
                        }

                        $meta = LanguageMeta::query()
                            ->where([
                                'lang_meta_origin' => $origin,
                                'lang_meta_code' => $language->lang_code,
                                'reference_type' => $modelClass,
                            ])
                            ->first();

                        $targetModel = $meta ? $modelClass::query()->find($meta->reference_id) : null;

                        if ($targetModel) {
                            $targetModel->fill($translatedData);
                            $targetModel->save();
                        } else {
                            $targetModel = $model->replicate();

                            foreach ($translatedData as $key => $value) {
                                $targetModel->{$key} = $value;
                            }

                            $targetModel->created_at = $model->created_at;
                            $targetModel->save();
                            $created = true;
                        }

                        LanguageMeta::query()->updateOrCreate(
                            [
                                'reference_id' => $targetModel->getKey(),
                                'reference_type' => $modelClass,
                            ],
                            [
                                'lang_meta_code' => $language->lang_code,
                                'lang_meta_origin' => $origin,
                            ]
                        );

                        if ($created && $config['hasSlug'] && isset($translatedData['name'])) {
                            SlugHelper::createSlug($targetModel, $translatedData['name']);
                        }
                    }

                    DB::commit();
                } catch (\Throwable $e) {
                    DB::rollBack();

                    Log::error('AI model auto translate save failed', [
                        'model_type' => $modelClass,
                        'model_id' => $model->getKey(),
                        'target_language' => $language->lang_code,
                        'message' => $e->getMessage(),
                    ]);

                    $results[] = [
                        'lang_code' => $language->lang_code,
                        'language' => $language->lang_name,
                        'success' => false,
                        'message' => 'Failed to save translated content.',
                    ];

                    continue;
                }

                $results[] = [
                    'lang_code' => $language->lang_code,
                    'language' => $language->lang_name,
                    'success' => true,
                    'created' => $created,
                    'model_id' => $model->getKey(),
                    'edit_url' => route($config['editRoute'], $model->getKey()) . '?ref_lang=' . $language->lang_code,
                    'cost' => $translation['cost'] ?? 0,
                ];
            }

            return $response
                ->setData(['results' => $results])
                ->setMessage('Translations completed.');
        } catch (\Throwable $e) {
            Log::error('AI model auto translate failed', [
                'model_type' => $request->input('model_type'),
                'model_id' => $request->input('model_id'),
                'languages' => $request->input('languages', []),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $response
                ->setError()
                ->setMessage('Auto-translate failed: ' . $e->getMessage());
        }
    }
}
