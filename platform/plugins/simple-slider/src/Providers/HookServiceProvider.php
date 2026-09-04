<?php

namespace Botble\SimpleSlider\Providers;

use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Supports\ServiceProvider;
use Botble\Language\Facades\Language;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\Shortcode\Compilers\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\SimpleSlider\Models\SimpleSlider;
use Botble\Theme\Facades\Theme;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class HookServiceProvider extends ServiceProvider
{
    protected function applyTranslation(Model $model, array $columns, ?string $currentLocale, ?string $defaultLocale): void
    {
        if (! $currentLocale || $currentLocale === $defaultLocale || ! $model->relationLoaded('translations')) {
            return;
        }

        $translation = $model->translations->firstWhere('lang_code', $currentLocale);

        if (! $translation) {
            return;
        }

        foreach ($columns as $column) {
            if (isset($translation->{$column})) {
                $model->setAttribute($column, $translation->{$column});
            }
        }
    }

    public function boot(): void
    {
        if (function_exists('shortcode')) {
            add_shortcode(
                'simple-slider',
                trans('plugins/simple-slider::simple-slider.simple_slider_shortcode_name'),
                trans('plugins/simple-slider::simple-slider.simple_slider_shortcode_description'),
                [$this, 'render']
            );

            shortcode()->setPreviewImage(
                'simple-slider',
                asset('vendor/core/plugins/simple-slider/images/ui-blocks/simple-slider.png')
            );

            shortcode()->setAdminConfig('simple-slider', function (array $attributes) {
                return ShortcodeForm::createFromArray($attributes)
                    ->add(
                        'key',
                        SelectField::class,
                        SelectFieldOption::make()
                            ->label(trans('plugins/simple-slider::simple-slider.select_slider'))
                            ->choices(SimpleSlider::query()
                                ->wherePublished()
                                ->pluck('name', 'key')
                                ->all())
                    )
                    ->withCaching(false);
            });

            shortcode()->ignoreLazyLoading(['simple-slider']);
            shortcode()->ignoreCaches(['simple-slider']);
        }
    }

    public function render(Shortcode $shortcode): View|Factory|Application|null
    {
        if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            LanguageAdvancedManager::initModelRelations();
        }

        $currentLocale = Language::getCurrentLocaleCode();
        $defaultLocale = Language::getDefaultLocaleCode();

        $slider = SimpleSlider::query()
            ->wherePublished()
            ->where('key', $shortcode->key)
            ->with([
                'translations' => fn ($query) => $query->when(
                    $currentLocale && $currentLocale !== $defaultLocale,
                    fn ($query) => $query->where('lang_code', $currentLocale)
                ),
                'sliderItems' => fn ($query) => $query
                    ->oldest('simple_slider_items.order')
                    ->with([
                        'translations' => fn ($query) => $query->when(
                            $currentLocale && $currentLocale !== $defaultLocale,
                            fn ($query) => $query->where('lang_code', $currentLocale)
                        ),
                    ]),
            ])
            ->first();

        if (empty($slider) || $slider->sliderItems->isEmpty()) {
            return null;
        }

        $this->applyTranslation($slider, ['name', 'description'], $currentLocale, $defaultLocale);

        foreach ($slider->sliderItems as $item) {
            $this->applyTranslation($item, ['title', 'description', 'link'], $currentLocale, $defaultLocale);
        }

        if (setting('simple_slider_using_assets', true) && defined('THEME_OPTIONS_MODULE_SCREEN_NAME')) {
            $version = '1.0.2';
            $dist = asset('vendor/core/plugins/simple-slider');

            Theme::asset()
                ->container('footer')
                ->usePath(false)
                ->add(
                    'simple-slider-owl-carousel-css',
                    $dist . '/libraries/owl-carousel/owl.carousel.css',
                    [],
                    [],
                    $version
                )
                ->add('simple-slider-css', $dist . '/css/simple-slider.css', [], [], $version)
                ->add(
                    'simple-slider-owl-carousel-js',
                    $dist . '/libraries/owl-carousel/owl.carousel.js',
                    ['jquery'],
                    [],
                    $version
                )
                ->add('simple-slider-js', $dist . '/js/simple-slider.js', ['jquery'], [], $version);
        }

        return view(apply_filters(SIMPLE_SLIDER_VIEW_TEMPLATE, 'plugins/simple-slider::sliders'), [
            'sliders' => $slider->sliderItems,
            'shortcode' => $shortcode,
            'slider' => $slider,
        ]);
    }
}
