<?php

namespace Botble\Restaurant;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('ht_restaurants_translations');
        Schema::dropIfExists('ht_restaurants');
        Schema::enableForeignKeyConstraints();
    }
}
