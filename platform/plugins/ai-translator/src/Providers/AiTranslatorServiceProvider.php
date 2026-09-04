<?php

namespace Botble\AiTranslator\Providers;

use Botble\ACL\Events\RoleUpdateEvent;
use Botble\ACL\Models\Role;
use Botble\AiTranslator\Services\AiTranslatorService;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Setting\Facades\Setting;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Schema;

class AiTranslatorServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->singleton(AiTranslatorService::class, function () {
            return new AiTranslatorService();
        });
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/ai-translator')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadAndPublishViews()
            ->loadRoutes()
            ->loadMigrations()
            ->publishAssets();

        $this->syncDefaultAdminPermissions();

        $this->app->register(HookServiceProvider::class);

        // Register admin assets globally for all admin pages
        $this->app['events']->listen(RouteMatched::class, function (): void {
            if (! defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                return;
            }

            dashboard_menu()
                ->registerItem([
                    'id' => 'cms-plugins-ai-translator',
                    'priority' => 900,
                    'parent_id' => null,
                    'name' => 'AI Translator',
                    'icon' => 'fa fa-language',
                    'url' => route('ai-translator.settings'),
                    'permissions' => ['ai-translator.settings'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-ai-translator-settings',
                    'priority' => 1,
                    'parent_id' => 'cms-plugins-ai-translator',
                    'name' => 'Settings',
                    'icon' => null,
                    'url' => route('ai-translator.settings'),
                    'permissions' => ['ai-translator.settings'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-ai-translator-training',
                    'priority' => 2,
                    'parent_id' => 'cms-plugins-ai-translator',
                    'name' => 'Training Data',
                    'icon' => null,
                    'url' => route('ai-translator.training.index'),
                    'permissions' => ['ai-translator.training'],
                ]);
        });
    }

    protected function syncDefaultAdminPermissions(): void
    {
        if (! Schema::hasTable('roles') || ! Schema::hasTable('settings')) {
            return;
        }

        if (setting('ai_translator_admin_permissions_synced')) {
            return;
        }

        $role = Role::query()
            ->where('slug', 'admin')
            ->first()
            ?: Role::query()->where('name', 'Admin')->first()
            ?: Role::query()->where('is_default', true)->first();

        if (! $role) {
            return;
        }

        $requiredPermissions = [
            'ai-translator.index' => true,
            'ai-translator.settings' => true,
            'ai-translator.training' => true,
        ];

        $permissions = array_merge((array) $role->permissions, $requiredPermissions);

        if ($permissions !== (array) $role->permissions) {
            $role->permissions = $permissions;
            $role->save();

            event(new RoleUpdateEvent($role));
        }

        Setting::set('ai_translator_admin_permissions_synced', '1');
        Setting::save();
    }
}
