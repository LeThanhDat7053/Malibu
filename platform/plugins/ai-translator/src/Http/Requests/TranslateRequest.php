<?php

namespace Botble\AiTranslator\Http\Requests;

use Botble\Support\Http\Requests\Request;

class TranslateRequest extends Request
{
    public function rules(): array
    {
        return [
            'text' => ['required', 'string', 'max:100000'],
            'target_language' => ['required', 'string', 'max:10'],
            'source_language' => ['nullable', 'string', 'max:10'],
            'field_type' => ['nullable', 'string', 'in:text,textarea,html'],
            'category' => ['nullable', 'string', 'max:100'],
            'model_type' => ['nullable', 'string', 'max:255'],
            'model_id' => ['nullable', 'integer'],
            'field_name' => ['nullable', 'string', 'max:100'],
        ];
    }
}
