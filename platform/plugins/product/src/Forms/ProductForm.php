<?php

namespace Botble\Product\Forms;

use Botble\Base\Forms\FieldOptions\ContentFieldOption;
use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\DatePickerField;
use Botble\Base\Forms\FieldOptions\DatePickerFieldOption;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Product\Http\Requests\ProductRequest;
use Botble\Product\Models\Product;
use Botble\Product\Models\ProductCategory;

class ProductForm extends FormAbstract
{
    public function setup(): void
    {
        $categories = ProductCategory::query()->pluck('name', 'id')->all();

        $daysOfWeek = [
            0 => trans('plugins/product::product.days.sunday'),
            1 => trans('plugins/product::product.days.monday'),
            2 => trans('plugins/product::product.days.tuesday'),
            3 => trans('plugins/product::product.days.wednesday'),
            4 => trans('plugins/product::product.days.thursday'),
            5 => trans('plugins/product::product.days.friday'),
            6 => trans('plugins/product::product.days.saturday'),
        ];

        $model = $this->getModel();
        $currentDays = ($model instanceof Product && $model->id) ? ($model->service_days ?? []) : [];

        $daysCheckboxesHtml = '<div class="form-group mb-3">'
            . '<label class="control-label">' . trans('plugins/product::product.service_days') . '</label>'
            . '<div class="d-flex flex-wrap gap-3">';
        foreach ($daysOfWeek as $value => $label) {
            $checked = in_array($value, $currentDays) ? 'checked' : '';
            $daysCheckboxesHtml .= '<label class="form-check-label me-3">'
                . '<input type="checkbox" name="service_days[]" value="' . $value . '" class="form-check-input" ' . $checked . '> '
                . $label
                . '</label>';
        }
        $daysCheckboxesHtml .= '</div></div>';

        $this
            ->setupModel(new Product())
            ->setValidatorClass(ProductRequest::class)
            ->withCustomFields()
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('description', TextareaField::class, DescriptionFieldOption::make()->toArray())
            ->add('content', EditorField::class, ContentFieldOption::make()->allowedShortcodes()->toArray())
            ->add(
                'is_featured',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(trans('core/base::forms.is_featured'))
                    ->defaultValue(false)
                    ->toArray()
            )
            ->add('price', 'text', [
                'label' => trans('plugins/product::product.price'),
                'required' => true,
                'attr' => [
                    'placeholder' => trans('plugins/product::product.price'),
                    'class' => 'form-control',
                ],
            ])
            ->add('original_price', 'text', [
                'label' => trans('plugins/product::product.original_price'),
                'attr' => [
                    'placeholder' => trans('plugins/product::product.original_price'),
                    'class' => 'form-control',
                ],
                'help_block' => [
                    'text' => 'Leave empty if there is only one price. If filled, it will display as a price range: Price - Max Price.',
                ],
            ])
            ->add('sale_start_date', DatePickerField::class,
                DatePickerFieldOption::make()
                    ->label(trans('plugins/product::product.sale_start_date'))
                    ->defaultValue($model instanceof Product && $model->sale_start_date ? $model->sale_start_date->format('Y-m-d') : '')
                    ->toArray()
            )
            ->add('sale_end_date', DatePickerField::class,
                DatePickerFieldOption::make()
                    ->label(trans('plugins/product::product.sale_end_date'))
                    ->defaultValue($model instanceof Product && $model->sale_end_date ? $model->sale_end_date->format('Y-m-d') : '')
                    ->toArray()
            )
            ->add(
                'enable_booking',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(trans('plugins/product::product.enable_booking'))
                    ->defaultValue(false)
                    ->toArray()
            )
            ->add('service_start_time', 'text', [
                'label' => trans('plugins/product::product.service_start_time'),
                'attr' => [
                    'placeholder' => 'HH:MM (e.g. 08:00)',
                    'class' => 'form-control',
                    'type' => 'time',
                ],
                'default_value' => $this->getModel()->service_start_time ?? '08:00',
            ])
            ->add('service_end_time', 'text', [
                'label' => trans('plugins/product::product.service_end_time'),
                'attr' => [
                    'placeholder' => 'HH:MM (e.g. 22:00)',
                    'class' => 'form-control',
                    'type' => 'time',
                ],
                'default_value' => $this->getModel()->service_end_time ?? '22:00',
            ])
            ->add('service_days_html', 'html', [
                'html' => $daysCheckboxesHtml,
            ])
            ->add('time_slot_duration', 'customSelect', [
                'label' => trans('plugins/product::product.time_slot_duration'),
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => [
                    30 => trans('plugins/product::product.minutes', ['count' => 30]),
                    60 => trans('plugins/product::product.minutes', ['count' => 60]),
                    90 => trans('plugins/product::product.minutes', ['count' => 90]),
                    120 => trans('plugins/product::product.minutes', ['count' => 120]),
                ],
                'default_value' => $this->getModel()->time_slot_duration ?? 60,
            ])
            ->add('image', MediaImageField::class, MediaImageFieldOption::make()->toArray())
            ->add('images', 'mediaImages', [
                'label' => trans('plugins/product::product.images'),
                'values' => $this->getModel()->id ? $this->getModel()->images : [],
                'attr' => [
                    'input_name' => 'images[]',
                ],
            ])
            ->add('order', 'number', [
                'label' => trans('core/base::forms.order'),
                'attr' => [
                    'placeholder' => trans('core/base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->add('category_id', 'customSelect', [
                'label' => trans('plugins/product::product.category'),
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => ['' => '-- Select --'] + $categories,
            ])
            ->setBreakFieldPoint('status');
    }
}
