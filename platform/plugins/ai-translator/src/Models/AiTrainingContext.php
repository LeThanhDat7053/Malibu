<?php

namespace Botble\AiTranslator\Models;

use Botble\Base\Models\BaseModel;

class AiTrainingContext extends BaseModel
{
    protected $table = 'ai_training_contexts';

    protected $fillable = [
        'source_language',
        'target_language',
        'category',
        'source_term',
        'target_term',
        'context_instruction',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
