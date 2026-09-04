<?php

return [
    // OpenAI API Key
    'openai_api_key' => env('OPENAI_API_KEY', ''),

    // Model to use for translation
    // gpt-4o-mini: cheapest, fast, good quality (~$0.15/1M input)
    // gpt-4o: best quality (~$2.50/1M input)
    // gpt-4.1-mini: latest efficient model
    'model' => env('AI_TRANSLATOR_MODEL', 'gpt-4o-mini'),

    // Default source language
    'default_source_language' => 'en',

    // Max tokens for response
    'max_tokens' => 4096,

    // Temperature (0 = deterministic, 1 = creative)
    'temperature' => 0.3,

    // Supported modules for translation
    'supported_modules' => [
        \Botble\Page\Models\Page::class,
        \Botble\Blog\Models\Post::class,
        \Botble\Blog\Models\Category::class,
        \Botble\Product\Models\Product::class,
    ],

    // Fields that can be translated per model
    'translatable_fields' => [
        'name' => 'text',
        'title' => 'text',
        'description' => 'textarea',
        'content' => 'html',
    ],
];
