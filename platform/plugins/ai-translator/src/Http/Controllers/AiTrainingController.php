<?php

namespace Botble\AiTranslator\Http\Controllers;

use Botble\AiTranslator\Http\Requests\TrainingContextRequest;
use Botble\AiTranslator\Models\AiTrainingContext;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Http\Request;

class AiTrainingController extends BaseController
{
    /**
     * Show training management page.
     */
    public function index()
    {
        page_title()->setTitle('AI Translation Prompt');

        return view('plugins/ai-translator::training');
    }

    /**
     * Store new training context.
     */
    public function store(TrainingContextRequest $request, BaseHttpResponse $response)
    {
        AiTrainingContext::create($request->validated());

        return $response->setMessage('Training context added successfully.');
    }

    /**
     * Update training context.
     */
    public function update(int $id, TrainingContextRequest $request, BaseHttpResponse $response)
    {
        $context = AiTrainingContext::findOrFail($id);
        $context->update($request->validated());

        return $response->setMessage('Training context updated.');
    }

    /**
     * Delete training context.
     */
    public function destroy(int $id, BaseHttpResponse $response)
    {
        AiTrainingContext::findOrFail($id)->delete();

        return $response->setMessage('Training context deleted.');
    }

    /**
     * API: Get all training contexts (for AJAX).
     */
    public function list(Request $request, BaseHttpResponse $response)
    {
        $query = AiTrainingContext::query();

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('target_language')) {
            $query->where(function ($q) use ($request) {
                $q->where('target_language', $request->input('target_language'))
                    ->orWhere('target_language', '*');
            });
        }

        $contexts = $query->where('is_active', true)->get();

        return $response->setData($contexts);
    }

    /**
     * Bulk import training contexts.
     */
    public function import(Request $request, BaseHttpResponse $response)
    {
        $request->validate([
            'contexts' => ['required', 'array'],
            'contexts.*.source_language' => ['required', 'string', 'max:10'],
            'contexts.*.target_language' => ['required', 'string', 'max:10'],
            'contexts.*.source_term' => ['nullable', 'string', 'max:500'],
            'contexts.*.target_term' => ['nullable', 'string', 'max:500'],
            'contexts.*.context_instruction' => ['nullable', 'string', 'max:5000'],
            'contexts.*.category' => ['nullable', 'string', 'max:100'],
        ]);

        $count = 0;
        foreach ($request->input('contexts') as $ctx) {
            AiTrainingContext::create(array_merge(
                ['is_active' => true, 'category' => 'general'],
                $ctx
            ));
            $count++;
        }

        return $response->setMessage("{$count} training contexts imported successfully.");
    }
}
