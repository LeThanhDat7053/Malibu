<?php

namespace Botble\SimpleSlider\Forms;

use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Language\Facades\Language;
use Botble\SimpleSlider\Http\Requests\SimpleSliderRequest;
use Botble\SimpleSlider\Models\SimpleSlider;
use Botble\SimpleSlider\Tables\SimpleSliderItemTable;
use Botble\Table\TableBuilder;

class SimpleSliderForm extends FormAbstract
{
    public function __construct(protected TableBuilder $tableBuilder)
    {
        parent::__construct();
    }

    public function setup(): void
    {
        $this->model(SimpleSlider::class);

        /** @var \Botble\SimpleSlider\Models\SimpleSlider $model */
        $model = $this->getModel();
        $defaultLocale = Language::getDefaultLocaleCode();
        $refLang = Language::getCurrentAdminLocaleCode();

        if ($refLang === $defaultLocale) {
            $refLang = null;
        }

        $itemTableUrl = route(
            'simple-slider-item.index',
            $model->getKey() ?: 0
        );

        if ($refLang) {
            $itemTableUrl .= '?' . http_build_query(['ref_lang' => $refLang]);
        }

        $this
            ->setValidatorClass(SimpleSliderRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add(
                'key',
                TextField::class,
                TextFieldOption::make()
                ->label(trans('plugins/simple-slider::simple-slider.key'))
                ->required()
                ->maxLength(120)
            )
            ->add('description', TextareaField::class, DescriptionFieldOption::make())
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('status')
            ->when($model->exists, function () use ($itemTableUrl, $model): void {
                $this->addMetaBoxes([
                    'slider-items' => [
                        'title' => trans('plugins/simple-slider::simple-slider.slide_items'),
                        'content' => $this->tableBuilder->create(SimpleSliderItemTable::class)
                            ->setAjaxUrl($itemTableUrl)
                            ->renderTable([
                                'simple_slider_id' => $model->getKey(),
                            ]),
                        'header_actions' => view('plugins/simple-slider::partials.header-actions', [
                            'slider' => $model,
                        ])->render(),
                        'has_table' => true,
                    ],
                ]);
            });
    }
}
