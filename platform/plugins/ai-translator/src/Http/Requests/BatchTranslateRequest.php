<?php

namespace Botble\AiTranslator\Http\Requests;

use Botble\Support\Http\Requests\Request;

class BatchTranslateRequest extends Request
{
    public function rules(): array
    {
        return [
            'fields' => ['required', 'array'],
            'fields.*.value' => ['required', 'string'],
            'fields.*.type' => ['nullable', 'string', 'in:text,textarea,html'],
            'target_language' => ['required', 'string', 'max:10'],
            'source_language' => ['nullable', 'string', 'max:10'],
            'category' => ['nullable', 'string', 'max:100'],
            'model_type' => ['nullable', 'string', 'max:255'],
            'model_id' => ['nullable', 'integer'],
        ];
    }
}
