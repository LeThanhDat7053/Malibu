<?php

namespace Botble\AiTranslator\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiTranslationLog extends BaseModel
{
    protected $table = 'ai_translation_logs';

    protected $fillable = [
        'user_id',
        'source_language',
        'target_language',
        'model_type',
        'model_id',
        'field_name',
        'input_tokens',
        'output_tokens',
        'ai_model',
        'estimated_cost',
        'api_key_hash',
    ];

    protected $casts = [
        'input_tokens' => 'integer',
        'output_tokens' => 'integer',
        'estimated_cost' => 'decimal:6',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\Botble\ACL\Models\User::class);
    }
}
