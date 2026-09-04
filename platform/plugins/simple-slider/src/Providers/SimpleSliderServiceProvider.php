<?php

namespace Botble\SimpleSlider\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\DashboardMenuItem;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Language\Facades\Language;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\SimpleSlider\Models\SimpleSlider;
use Botble\SimpleSlider\Models\SimpleSliderItem;
use Botble\SimpleSlider\Repositories\Eloquent\SimpleSliderItemRepository;
use Botble\SimpleSlider\Repositories\Eloquent\SimpleSliderRepository;
use Botble\SimpleSlider\Repositories\Interfaces\SimpleSliderInterface;
use Botble\SimpleSlider\Repositories\Interfaces\SimpleSliderItemInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SimpleSliderServiceProvider extends ServiceProvider implements DeferrableProvider
{
    use LoadAndPublishDataTrait;

    protected function syncDefaultTranslation(Model $model, array $columns): void
    {
        if (! defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            return;
        }

        $defaultLanguage = Language::getDefaultLocaleCode();

        if (! $defaultLanguage) {
            return;
        }

        $table = $model->getTable() . '_translations';
        $foreignKey = $model->getTable() . '_id';
        $freshModel = $model->newQuery()->find($model->getKey());

        if (! $freshModel) {
            return;
        }

        $data = ['lang_code' => $defaultLanguage, $foreignKey => $model->getKey()];

        foreach ($columns as $column) {
            $data[$column] = $freshModel->getRawOriginal($column);
        }

        DB::table($table)->updateOrInsert([
            'lang_code' => $defaultLanguage,
            $foreignKey => $model->getKey(),
        ], $data);
    }

    public function register(): void
    {
        $this->app->bind(SimpleSliderInterface::class, function () {
            return new SimpleSliderRepository(new SimpleSlider());
        });

        $this->app->bind(SimpleSliderItemInterface::class, function () {
            return new SimpleSliderItemRepository(new SimpleSliderItem());
        });
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/simple-slider')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web', 'api'])
            ->loadMigrations()
            ->publishAssets();

        DashboardMenu::default()->beforeRetrieving(function (): void {
            DashboardMenu::make()
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-plugins-simple-slider')
                        ->priority(390)
                        ->name('plugins/simple-slider::simple-slider.menu')
                        ->icon('ti ti-slideshow')
                        ->route('simple-slider.index')
                );
        });

        if (defined('LANGUAGE_MODULE_SCREEN_NAME') && defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            LanguageAdvancedManager::registerModule(SimpleSlider::class, [
                'name',
                'description',
            ]);

            LanguageAdvancedManager::registerModule(SimpleSliderItem::class, [
                'title',
                'description',
                'link',
            ]);

            LanguageAdvancedManager::addTranslatableMetaBox('slider-items');
        }

        $this->app->booted(function (): void {
            $this->app->register(HookServiceProvider::class);
        });

        SimpleSlider::saved(function (SimpleSlider $slider): void {
            $this->syncDefaultTranslation($slider, ['name', 'description']);
        });

        SimpleSliderItem::saved(function (SimpleSliderItem $item): void {
            $this->syncDefaultTranslation($item, ['title', 'description', 'link']);
        });
    }

    public function provides(): array
    {
        return [
            SimpleSliderInterface::class,
            SimpleSliderItemInterface::class,
        ];
    }
}
