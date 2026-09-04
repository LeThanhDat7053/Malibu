<?php

namespace Botble\AiTranslator;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('ai_translation_logs');
        Schema::dropIfExists('ai_training_contexts');
    }
}
