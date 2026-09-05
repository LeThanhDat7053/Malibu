<?php

namespace Botble\Restaurant\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Gallery\Facades\Gallery;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\Restaurant\Models\Restaurant;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Slug\Facades\SlugHelper;
use Illuminate\Support\ServiceProvider;

class RestaurantServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->setNamespace('plugins/restaurant')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes()
            ->loadHelpers();

        SlugHelper::registering(function (): void {
            SlugHelper::registerModule(
                Restaurant::class,
                fn () => trans('plugins/restaurant::restaurant.name')
            );
            SlugHelper::setPrefix(Restaurant::class, 'nha-hang');
        });

        DashboardMenu::default()->beforeRetrieving(function (): void {
            DashboardMenu::make()->registerItem([
                'id' => 'cms-plugins-restaurant',
                'priority' => 3,
                'name' => 'plugins/restaurant::restaurant.name',
                'icon' => 'ti ti-tools-kitchen-2',
                'route' => 'restaurant.index',
            ]);
        });

        $this->app->booted(function (): void {
            // Cho phép dùng lưới ảnh / video / VR360 của plugin Gallery.
            if (is_plugin_active('gallery')) {
                Gallery::registerModule(Restaurant::class);
            }

            SeoHelper::registerModule([Restaurant::class]);
        });

        if (defined('LANGUAGE_MODULE_SCREEN_NAME') && defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            LanguageAdvancedManager::registerModule(Restaurant::class, [
                'name',
                'description',
                'content',
                'location',
                'capacity',
                'opening_hours',
                'opening_hours_items',
                'cuisine',
            ]);
        }
    }
}
