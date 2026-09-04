<?php

namespace Botble\AiTranslator\Http\Requests;

use Botble\Support\Http\Requests\Request;

class TrainingContextRequest extends Request
{
    public function rules(): array
    {
        return [
            'source_language' => ['required', 'string', 'max:10'],
            'target_language' => ['required', 'string', 'max:10'],
            'category' => ['nullable', 'string', 'max:100'],
            'source_term' => ['nullable', 'string', 'max:500'],
            'target_term' => ['nullable', 'string', 'max:500'],
            'context_instruction' => ['nullable', 'string', 'max:5000'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
