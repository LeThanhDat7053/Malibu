<?php

namespace Botble\AiTranslator\Services;

use Botble\AiTranslator\Models\AiTrainingContext;
use Botble\AiTranslator\Models\AiTranslationLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Throwable;

class AiTranslatorService
{
    protected string $apiKey;
    protected string $model;
    protected int $maxTokens;
    protected float $temperature;

    // Cost per 1M tokens (USD) for different models
    protected array $pricing = [
        'gpt-4.1-nano' => ['input' => 0.10, 'output' => 0.40],
        'gpt-4o-mini' => ['input' => 0.15, 'output' => 0.60],
        'gpt-4.1-mini' => ['input' => 0.40, 'output' => 1.60],
        'gpt-3.5-turbo' => ['input' => 0.50, 'output' => 1.50],
        'o4-mini' => ['input' => 1.10, 'output' => 4.40],
        'o3-mini' => ['input' => 1.10, 'output' => 4.40],
        'o1-mini' => ['input' => 1.10, 'output' => 4.40],
        'gpt-4.1' => ['input' => 2.00, 'output' => 8.00],
        'o3' => ['input' => 2.00, 'output' => 8.00],
        'gpt-4o' => ['input' => 2.50, 'output' => 10.00],
        'gpt-4-turbo' => ['input' => 10.00, 'output' => 30.00],
        'o1' => ['input' => 15.00, 'output' => 60.00],
        'gpt-4' => ['input' => 30.00, 'output' => 60.00],
        'gpt-4.5-preview' => ['input' => 75.00, 'output' => 150.00],
    ];

    public function __construct()
    {
        $this->apiKey = (string) setting('ai_translator_api_key', config('plugins.ai-translator.general.openai_api_key'));
        $this->model = (string) setting('ai_translator_model', config('plugins.ai-translator.general.model'));
        $this->maxTokens = (int) config('plugins.ai-translator.general.max_tokens', 4096);
        $this->temperature = (float) config('plugins.ai-translator.general.temperature', 0.3);
    }

    /**
     * Get a short hash of the current API key for tracking usage per key.
     */
    public function getApiKeyHash(): string
    {
        return $this->apiKey ? substr(hash('sha256', $this->apiKey), 0, 16) : '';
    }

    /**
     * Check if the api_key_hash column exists (migration may not have run yet).
     */
    public function hasApiKeyHashColumn(): bool
    {
        static $exists = null;

        if ($exists === null) {
            $exists = Schema::hasColumn('ai_translation_logs', 'api_key_hash');
        }

        return $exists;
    }

    /**
     * Translate text from source language to target language.
     */
    public function translate(
        string $text,
        string $targetLanguage,
        string $sourceLanguage = 'en',
        string $fieldType = 'text',
        ?string $category = 'general',
        ?string $modelType = null,
        ?int $modelId = null,
        ?string $fieldName = null
    ): array {
        if (empty($this->apiKey)) {
            return ['success' => false, 'error' => 'OpenAI API key is not configured.'];
        }

        if (empty(trim($text))) {
            return ['success' => true, 'translated' => ''];
        }

        $systemPrompt = $this->buildSystemPrompt($sourceLanguage, $targetLanguage, $fieldType, $category);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])
                ->timeout(60)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $text],
                    ],
                    'max_tokens' => $this->maxTokens,
                    'temperature' => $this->temperature,
                ]);

            if (! $response->successful()) {
                $error = $response->json('error.message', 'Unknown API error');
                Log::error('AI Translator API error', ['error' => $error, 'status' => $response->status()]);
                return ['success' => false, 'error' => $error];
            }

            $data = $response->json();
            $translated = $data['choices'][0]['message']['content'] ?? '';
            $inputTokens = $data['usage']['prompt_tokens'] ?? 0;
            $outputTokens = $data['usage']['completion_tokens'] ?? 0;
            $cost = $this->calculateCost($inputTokens, $outputTokens);

            // Log the translation
            AiTranslationLog::create([
                'user_id' => auth()->id(),
                'source_language' => $sourceLanguage,
                'target_language' => $targetLanguage,
                'model_type' => $modelType,
                'model_id' => $modelId,
                'field_name' => $fieldName,
                'input_tokens' => $inputTokens,
                'output_tokens' => $outputTokens,
                'ai_model' => $this->model,
                'estimated_cost' => $cost,
            ] + ($this->hasApiKeyHashColumn() ? ['api_key_hash' => $this->getApiKeyHash()] : []));

            return [
                'success' => true,
                'translated' => trim($translated),
                'tokens' => ['input' => $inputTokens, 'output' => $outputTokens],
                'cost' => $cost,
            ];
        } catch (Throwable $e) {
            Log::error('AI Translator exception', ['message' => $e->getMessage()]);
            return ['success' => false, 'error' => 'Translation failed: ' . $e->getMessage()];
        }
    }

    /**
     * Translate multiple fields at once (batch).
     * Automatically preprocesses shortcode and full-HTML content for reliable translation.
     */
    public function translateBatch(
        array $fields,
        string $targetLanguage,
        string $sourceLanguage = 'en',
        ?string $category = 'general',
        ?string $modelType = null,
        ?int $modelId = null
    ): array {
        if (empty($this->apiKey)) {
            return ['success' => false, 'error' => 'OpenAI API key is not configured.'];
        }

        // Pre-process: extract translatable segments from shortcode/HTML content
        $preprocessed = [];
        $cleanFields = [];

        foreach ($fields as $fieldName => $fieldData) {
            $value = trim($fieldData['value'] ?? '');
            if (empty($value)) {
                continue;
            }

            // Detect Botble CMS shortcode content: [shortcode-name ...] or <shortcode>[...]</shortcode>
            if (preg_match('/\[[\w][\w-]*[\s\]]/', $value)) {
                $extracted = $this->extractShortcodeTexts($value, $fieldName . '_');
                if (! empty($extracted['segments'])) {
                    foreach ($extracted['segments'] as $key => $text) {
                        $cleanFields[$key] = ['value' => $text, 'type' => 'text'];
                    }
                    $preprocessed[$fieldName] = ['type' => 'shortcode', 'data' => $extracted];
                    continue;
                }
            }

            // Detect content with HTML tags (full documents, fragments, or inline HTML)
            if (preg_match('/<(?:[a-z][\w-]*[\s>]|!doctype)/i', $value)) {
                $extracted = $this->extractHtmlTexts($value, $fieldName . '_');
                if (! empty($extracted['segments'])) {
                    foreach ($extracted['segments'] as $key => $text) {
                        $cleanFields[$key] = ['value' => $text, 'type' => 'text'];
                    }
                    $preprocessed[$fieldName] = ['type' => 'html', 'data' => $extracted];
                    continue;
                }
            }

            // Regular field — pass through
            $cleanFields[$fieldName] = ['value' => $value, 'type' => $fieldData['type'] ?? 'text'];
        }

        if (empty($cleanFields)) {
            return ['success' => true, 'translations' => []];
        }

        $systemPrompt = $this->buildBatchSystemPrompt($sourceLanguage, $targetLanguage, $category);

        $userContent = "Translate the following fields. Return a JSON object with the same keys, containing only the translated values.\n\n";
        $userContent .= json_encode(
            array_map(fn ($f) => $f['value'], $cleanFields),
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])
                ->timeout(120)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userContent],
                    ],
                    'max_tokens' => $this->maxTokens * 3,
                    'temperature' => $this->temperature,
                    'response_format' => ['type' => 'json_object'],
                ]);

            if (! $response->successful()) {
                $error = $response->json('error.message', 'Unknown API error');
                return ['success' => false, 'error' => $error];
            }

            $data = $response->json();
            $content = $data['choices'][0]['message']['content'] ?? '{}';
            $translations = json_decode($content, true) ?? [];
            $inputTokens = $data['usage']['prompt_tokens'] ?? 0;
            $outputTokens = $data['usage']['completion_tokens'] ?? 0;
            $cost = $this->calculateCost($inputTokens, $outputTokens);

            // Post-process: reassemble preprocessed fields from translated segments
            foreach ($preprocessed as $fieldName => $info) {
                $template = $info['data']['template'];
                $encoding = $info['data']['encoding'] ?? [];

                foreach ($info['data']['segments'] as $placeholder => $original) {
                    $translated = $translations[$placeholder] ?? $original;
                    // Re-encode if the original was in &quot; quoted context
                    if (! empty($encoding[$placeholder])) {
                        $translated = htmlspecialchars($translated, ENT_QUOTES, 'UTF-8', false);
                    }
                    $template = str_replace($placeholder, $translated, $template);
                    unset($translations[$placeholder]);
                }

                // Restore <style> and <script> blocks for HTML content
                if ($info['type'] === 'html') {
                    foreach ($info['data']['styles'] ?? [] as $key => $style) {
                        $template = str_replace($key, $style, $template);
                    }
                    foreach ($info['data']['scripts'] ?? [] as $key => $script) {
                        $template = str_replace($key, $script, $template);
                    }
                }

                $translations[$fieldName] = $template;
            }

            AiTranslationLog::create([
                'user_id' => auth()->id(),
                'source_language' => $sourceLanguage,
                'target_language' => $targetLanguage,
                'model_type' => $modelType,
                'model_id' => $modelId,
                'field_name' => 'batch:' . implode(',', array_keys($fields)),
                'input_tokens' => $inputTokens,
                'output_tokens' => $outputTokens,
                'ai_model' => $this->model,
                'estimated_cost' => $cost,
            ] + ($this->hasApiKeyHashColumn() ? ['api_key_hash' => $this->getApiKeyHash()] : []));

            return [
                'success' => true,
                'translations' => $translations,
                'tokens' => ['input' => $inputTokens, 'output' => $outputTokens],
                'cost' => $cost,
            ];
        } catch (Throwable $e) {
            Log::error('AI Translator batch exception', ['message' => $e->getMessage()]);
            return ['success' => false, 'error' => 'Batch translation failed: ' . $e->getMessage()];
        }
    }

    /**
     * Extract translatable text from Botble CMS shortcode content.
     * Returns template with placeholders and a map of placeholder => decoded text.
     */
    protected function extractShortcodeTexts(string $content, string $prefix = ''): array
    {
        // Shortcode attributes containing user-visible text
        $translatableAttrs = [
            'title', 'subtitle', 'description', 'button_label', 'button_primary_label',
            'highlights', 'form_title', 'form_button_label', 'title_button',
            'address_label', 'address_detail', 'email_label', 'email_detail',
            'work_time_label', 'work_time_detail', 'phone_label', 'phone_detail',
            'signature_author',
        ];
        // Numbered variants: title_1, description_2, feature_list_1, name_3, button_label_2
        $numberedPrefixes = ['title', 'description', 'feature_list', 'name', 'button_label'];

        $attrNames = array_map(fn ($a) => preg_quote($a, '/'), $translatableAttrs);
        $numPatterns = array_map(fn ($p) => preg_quote($p, '/') . '_\d+', $numberedPrefixes);
        $attrPattern = '(?:' . implode('|', array_merge($attrNames, $numPatterns)) . ')';

        $segments = [];
        $encoding = [];
        $counter = 0;

        // Pass 1: Handle attr="value" format (raw quotes)
        $template = preg_replace_callback(
            '/\b(' . $attrPattern . ')="([^"]*)"/',
            function ($match) use (&$segments, &$encoding, &$counter, $prefix) {
                $value = $match[2];
                if (empty(trim($value))) {
                    return $match[0];
                }

                $placeholder = '___AITL_' . $prefix . $counter . '___';
                $segments[$placeholder] = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $encoding[$placeholder] = false; // Raw quotes: don't re-encode
                $counter++;

                return $match[1] . '="' . $placeholder . '"';
            },
            $content
        );

        // Pass 2: Handle attr=&quot;value&quot; format (entity-encoded quotes)
        $template = preg_replace_callback(
            '/\b(' . $attrPattern . ')=&quot;((?:(?!&quot;).)*)&quot;/s',
            function ($match) use (&$segments, &$encoding, &$counter, $prefix) {
                $value = $match[2];
                if (empty(trim($value))) {
                    return $match[0];
                }

                $placeholder = '___AITL_' . $prefix . $counter . '___';
                $segments[$placeholder] = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $encoding[$placeholder] = true; // Entity quotes: re-encode on reassembly
                $counter++;

                return $match[1] . '=&quot;' . $placeholder . '&quot;';
            },
            $template
        );

        return [
            'template' => $template,
            'segments' => $segments,
            'encoding' => $encoding,
        ];
    }

    /**
     * Extract translatable text from a full HTML document.
     * Preserves CSS, JS, and HTML structure; only extracts visible text content.
     */
    protected function extractHtmlTexts(string $content, string $prefix = ''): array
    {
        $segments = [];
        $encoding = [];
        $counter = 0;

        // Store and remove <style> blocks
        $styles = [];
        $template = preg_replace_callback('/<style\b[^>]*>.*?<\/style>/si', function ($m) use (&$styles, $prefix) {
            $key = '___AISTYLE_' . $prefix . count($styles) . '___';
            $styles[$key] = $m[0];
            return $key;
        }, $content);

        // Store and remove <script> blocks
        $scripts = [];
        $template = preg_replace_callback('/<script\b[^>]*>.*?<\/script>/si', function ($m) use (&$scripts, $prefix) {
            $key = '___AISCR_' . $prefix . count($scripts) . '___';
            $scripts[$key] = $m[0];
            return $key;
        }, $template);

        // Extract text content between HTML tags: >text<
        $template = preg_replace_callback('/>([^<]+)</', function ($match) use (&$segments, &$encoding, &$counter, $prefix) {
            $text = $match[1];
            $decoded = html_entity_decode(trim($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');

            // Skip whitespace-only or non-letter text (numbers, symbols, &nbsp;)
            if (empty($decoded) || ! preg_match('/\p{L}/u', $decoded)) {
                return $match[0];
            }

            $placeholder = '___AITL_' . $prefix . $counter . '___';
            $segments[$placeholder] = $decoded;
            $encoding[$placeholder] = true;
            $counter++;

            // Preserve surrounding whitespace
            $leading = '';
            $trailing = '';
            if (preg_match('/^(\s+)/', $text, $m)) {
                $leading = $m[1];
            }
            if (preg_match('/(\s+)$/', $text, $m)) {
                $trailing = $m[1];
            }

            return '>' . $leading . $placeholder . $trailing . '<';
        }, $template);

        // Extract translatable HTML attributes (alt, title)
        $template = preg_replace_callback(
            '/\b(alt|title|placeholder|aria-label)="([^"]*)"/',
            function ($match) use (&$segments, &$encoding, &$counter, $prefix) {
                $value = html_entity_decode($match[2], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                if (empty(trim($value)) || ! preg_match('/\p{L}/u', $value)) {
                    return $match[0];
                }

                $placeholder = '___AITL_' . $prefix . $counter . '___';
                $segments[$placeholder] = $value;
                $encoding[$placeholder] = true;
                $counter++;

                return $match[1] . '="' . $placeholder . '"';
            },
            $template
        );

        return [
            'template' => $template,
            'segments' => $segments,
            'encoding' => $encoding,
            'styles' => $styles,
            'scripts' => $scripts,
        ];
    }

    /**
     * Build the system prompt with training context.
     */
    protected function buildSystemPrompt(
        string $sourceLanguage,
        string $targetLanguage,
        string $fieldType = 'text',
        ?string $category = 'general'
    ): string {
        $langNames = $this->getLanguageNames();
        $sourceName = $langNames[$sourceLanguage] ?? $sourceLanguage;
        $targetName = $langNames[$targetLanguage] ?? $targetLanguage;

        $prompt = "You are a professional translator. Translate the following content from {$sourceName} to {$targetName}.\n\n";

        $prompt .= "Rules:\n";
        $prompt .= "- Return ONLY the translated text, no explanations or notes.\n";
        $prompt .= "- Maintain the same tone, style, and formatting as the original.\n";
        $prompt .= "- Keep proper nouns, brand names, and technical terms unchanged unless a specific translation is provided.\n";

        if ($fieldType === 'html') {
            $prompt .= "- Preserve all HTML tags, attributes, and structure. Only translate the text content within tags.\n";
            $prompt .= "- Do not translate HTML attributes like class, id, href, src, etc.\n";
        }

        // Add training context from database
        $trainingContext = $this->getTrainingContext($sourceLanguage, $targetLanguage, $category);
        if (! empty($trainingContext)) {
            $prompt .= "\nCustom Translation Rules:\n" . $trainingContext;
        }

        // Add custom prompt from settings
        $customPrompt = trim((string) setting('ai_translator_prompt', ''));
        if (! empty($customPrompt)) {
            $prompt .= "\n\nAdditional Instructions:\n" . $customPrompt;
        }

        return $prompt;
    }

    /**
     * Build system prompt for batch translation.
     */
    protected function buildBatchSystemPrompt(
        string $sourceLanguage,
        string $targetLanguage,
        ?string $category = 'general'
    ): string {
        $langNames = $this->getLanguageNames();
        $sourceName = $langNames[$sourceLanguage] ?? $sourceLanguage;
        $targetName = $langNames[$targetLanguage] ?? $targetLanguage;

        $prompt = "You are a professional translator. Translate content from {$sourceName} to {$targetName}.\n\n";
        $prompt .= "Rules:\n";
        $prompt .= "- You will receive a JSON object with field names as keys and text to translate as values.\n";
        $prompt .= "- Return a JSON object with the SAME keys, containing the translated values.\n";
        $prompt .= "- Maintain the same tone, style, and formatting.\n";
        $prompt .= "- If a value contains HTML, preserve all HTML tags and attributes. Only translate text content.\n";
        $prompt .= "- Keep proper nouns and brand names unchanged unless a specific translation is provided below.\n";

        $trainingContext = $this->getTrainingContext($sourceLanguage, $targetLanguage, $category);
        if (! empty($trainingContext)) {
            $prompt .= "\nCustom Translation Rules:\n" . $trainingContext;
        }

        // Add custom prompt from settings
        $customPrompt = trim((string) setting('ai_translator_prompt', ''));
        if (! empty($customPrompt)) {
            $prompt .= "\n\nAdditional Instructions:\n" . $customPrompt;
        }

        return $prompt;
    }

    /**
     * Get training context for a language pair.
     */
    protected function getTrainingContext(string $sourceLanguage, string $targetLanguage, ?string $category = 'general'): string
    {
        $contexts = AiTrainingContext::query()
            ->where('is_active', true)
            ->where(function ($q) use ($sourceLanguage) {
                $q->where('source_language', $sourceLanguage)->orWhere('source_language', '*');
            })
            ->where(function ($q) use ($targetLanguage) {
                $q->where('target_language', $targetLanguage)->orWhere('target_language', '*');
            })
            ->where(function ($q) use ($category) {
                $q->where('category', 'general')
                    ->orWhere('category', $category);
            })
            ->orderBy('category')
            ->get();

        $parts = [];

        foreach ($contexts as $ctx) {
            if (! empty($ctx->source_term) && ! empty($ctx->target_term)) {
                $parts[] = "- \"{$ctx->source_term}\" → \"{$ctx->target_term}\"";
            }
            if (! empty($ctx->context_instruction)) {
                $parts[] = "- {$ctx->context_instruction}";
            }
        }

        return implode("\n", $parts);
    }

    /**
     * Calculate estimated cost in USD.
     */
    protected function calculateCost(int $inputTokens, int $outputTokens): float
    {
        $modelPricing = $this->pricing[$this->model] ?? $this->pricing['gpt-4o-mini'];
        return ($inputTokens * $modelPricing['input'] / 1000000) + ($outputTokens * $modelPricing['output'] / 1000000);
    }

    /**
     * Get usage stats.
     */
    public function getUsageStats(?string $period = 'month', bool $currentKeyOnly = true): array
    {
        $query = AiTranslationLog::query();

        if ($period === 'today') {
            $query->whereDate('created_at', today());
        } elseif ($period === 'week') {
            $query->where('created_at', '>=', now()->startOfWeek());
        } elseif ($period === 'month') {
            $query->where('created_at', '>=', now()->startOfMonth());
        }

        // Filter by current API key hash so usage resets when key changes
        if ($currentKeyOnly && $this->hasApiKeyHashColumn()) {
            $hash = $this->getApiKeyHash();
            if ($hash) {
                $query->where('api_key_hash', $hash);
            }
        }

        // Recalculate cost from tokens + model (don't trust stored estimated_cost)
        $logs = $query->select(['input_tokens', 'output_tokens', 'ai_model'])->get();
        $totalCost = 0.0;
        $totalInputTokens = 0;
        $totalOutputTokens = 0;

        foreach ($logs as $log) {
            $totalInputTokens += $log->input_tokens;
            $totalOutputTokens += $log->output_tokens;
            $p = $this->pricing[$log->ai_model] ?? $this->pricing['gpt-4o-mini'];
            $totalCost += ($log->input_tokens * $p['input'] / 1000000) + ($log->output_tokens * $p['output'] / 1000000);
        }

        return [
            'total_requests' => $logs->count(),
            'total_input_tokens' => $totalInputTokens,
            'total_output_tokens' => $totalOutputTokens,
            'total_cost' => round($totalCost, 4),
        ];
    }

    protected function getLanguageNames(): array
    {
        return [
            'en' => 'English',
            'vi' => 'Vietnamese',
            'ko' => 'Korean',
            'ko_KR' => 'Korean',
            'zh' => 'Chinese (Simplified)',
            'zh_CN' => 'Chinese (Simplified)',
            'zh_TW' => 'Chinese (Traditional)',
            'ja' => 'Japanese',
            'fr' => 'French',
            'de' => 'German',
            'es' => 'Spanish',
            'pt' => 'Portuguese',
            'ru' => 'Russian',
            'th' => 'Thai',
            'id' => 'Indonesian',
            'ms' => 'Malay',
            'ar' => 'Arabic',
        ];
    }

    /**
     * Test the API connection.
     */
    public function testConnection(): array
    {
        if (empty($this->apiKey)) {
            return ['success' => false, 'error' => 'API key is not configured.'];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->timeout(10)->get('https://api.openai.com/v1/models');

            if ($response->successful()) {
                return ['success' => true, 'message' => 'Connection successful!'];
            }

            return ['success' => false, 'error' => $response->json('error.message', 'Connection failed')];
        } catch (Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Fetch real usage data from OpenAI API (requires admin key).
     * Returns null if the API key doesn't have permission.
     */
    public function fetchOpenAiUsage(): ?array
    {
        if (empty($this->apiKey)) {
            return null;
        }

        try {
            $startTime = now()->startOfMonth()->timestamp;
            $endTime = now()->timestamp;

            // Try the costs endpoint first (gives dollar amounts)
            $costsResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(15)->get('https://api.openai.com/v1/organization/costs', [
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);

            $totalCost = 0.0;
            $costSuccess = false;

            if ($costsResponse->successful()) {
                $costsData = $costsResponse->json();
                foreach ($costsData['data'] ?? [] as $bucket) {
                    foreach ($bucket['results'] ?? [] as $result) {
                        $totalCost += $result['amount']['value'] ?? 0;
                    }
                }
                $costSuccess = true;
            }

            // Try the completions usage endpoint (gives token counts)
            $usageResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(15)->get('https://api.openai.com/v1/organization/usage/completions', [
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);

            $totalInputTokens = 0;
            $totalOutputTokens = 0;
            $totalRequests = 0;
            $usageSuccess = false;

            if ($usageResponse->successful()) {
                $usageData = $usageResponse->json();
                foreach ($usageData['data'] ?? [] as $bucket) {
                    foreach ($bucket['results'] ?? [] as $result) {
                        $totalInputTokens += $result['input_tokens'] ?? 0;
                        $totalOutputTokens += $result['output_tokens'] ?? 0;
                        $totalRequests += $result['num_model_requests'] ?? 0;
                    }
                }
                $usageSuccess = true;
            }

            if (! $costSuccess && ! $usageSuccess) {
                return null;
            }

            return [
                'total_requests' => $totalRequests,
                'total_input_tokens' => $totalInputTokens,
                'total_output_tokens' => $totalOutputTokens,
                'total_cost' => round($totalCost, 4),
                'source' => 'openai_api',
            ];
        } catch (Throwable $e) {
            Log::debug('OpenAI Usage API not available', ['error' => $e->getMessage()]);

            return null;
        }
    }
}
