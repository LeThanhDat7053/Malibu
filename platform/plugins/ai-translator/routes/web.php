<?php

use Botble\AiTranslator\Http\Controllers\AiTranslatorController;
use Botble\AiTranslator\Http\Controllers\AiTrainingController;
use Botble\Base\Facades\AdminHelper;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function (): void {
    Route::group(['prefix' => 'ai-translator', 'as' => 'ai-translator.'], function (): void {
        // Translation API endpoints
        Route::post('translate', [AiTranslatorController::class, 'translate'])
            ->name('translate');

        Route::post('translate-batch', [AiTranslatorController::class, 'translateBatch'])
            ->name('translate-batch');

        Route::post('blog-auto-translate', [AiTranslatorController::class, 'translateBlogPostAll'])
            ->name('blog-auto-translate');

        Route::post('model-auto-translate', [AiTranslatorController::class, 'translateModelAll'])
            ->name('model-auto-translate');

        // Settings
        Route::get('settings', [AiTranslatorController::class, 'settings'])
            ->name('settings');

        Route::post('settings', [AiTranslatorController::class, 'saveSettings'])
            ->name('settings.save');

        Route::post('test-connection', [AiTranslatorController::class, 'testConnection'])
            ->name('test-connection');

        Route::get('usage-stats', [AiTranslatorController::class, 'usageStats'])
            ->name('usage-stats');

        Route::post('reset-usage', [AiTranslatorController::class, 'resetUsage'])
            ->name('reset-usage');

        Route::get('languages', [AiTranslatorController::class, 'getLanguages'])
            ->name('languages');

        Route::post('fetch-original', [AiTranslatorController::class, 'fetchOriginal'])
            ->name('fetch-original');

        // Training context management
        Route::group(['prefix' => 'training', 'as' => 'training.'], function (): void {
            Route::get('/', [AiTrainingController::class, 'index'])->name('index');
            Route::post('/', [AiTrainingController::class, 'store'])->name('store');
            Route::put('{id}', [AiTrainingController::class, 'update'])->name('update');
            Route::delete('{id}', [AiTrainingController::class, 'destroy'])->name('destroy');
            Route::get('list', [AiTrainingController::class, 'list'])->name('list');
            Route::post('import', [AiTrainingController::class, 'import'])->name('import');
        });
    });
});
