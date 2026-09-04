<?php

namespace Botble\Restaurant\Forms;

use Botble\Base\Facades\Assets;
use Botble\Base\Forms\FieldOptions\ContentFieldOption;
use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\SortOrderFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Restaurant\Http\Requests\RestaurantRequest;
use Botble\Restaurant\Models\Restaurant;

class RestaurantForm extends FormAbstract
{
    public function setup(): void
    {
        // Nạp asset của plugin Gallery để lưới ảnh/video/VR360 hoạt động,
        // giống cách RoomForm làm.
        Assets::addStylesDirectly(['vendor/core/plugins/gallery/css/admin-gallery.css'])
            ->addScriptsDirectly(['vendor/core/plugins/gallery/js/gallery-admin.js']);

        $half = $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-6';

        $this
            ->setupModel(new Restaurant())
            ->setValidatorClass(RestaurantRequest::class)
            ->withCustomFields()
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('description', TextareaField::class, DescriptionFieldOption::make()->toArray())

            ->add('rowOpen1', 'html', ['html' => '<div class="row">'])
            ->add('location', TextField::class, [
                'label' => trans('plugins/restaurant::restaurant.location'),
                'wrapper' => ['class' => $half],
                'attr' => [
                    'placeholder' => trans('plugins/restaurant::restaurant.location_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('capacity', TextField::class, [
                'label' => trans('plugins/restaurant::restaurant.capacity'),
                'wrapper' => ['class' => $half],
                'attr' => [
                    'placeholder' => trans('plugins/restaurant::restaurant.capacity_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('opening_hours', TextField::class, [
                'label' => trans('plugins/restaurant::restaurant.opening_hours'),
                'wrapper' => ['class' => $half],
                'attr' => [
                    'placeholder' => trans('plugins/restaurant::restaurant.opening_hours_placeholder'),
                    'data-counter' => 160,
                ],
            ])
            ->add('cuisine', TextField::class, [
                'label' => trans('plugins/restaurant::restaurant.cuisine'),
                'wrapper' => ['class' => $half],
                'attr' => [
                    'placeholder' => trans('plugins/restaurant::restaurant.cuisine_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('phone', TextField::class, [
                'label' => trans('plugins/restaurant::restaurant.phone'),
                'wrapper' => ['class' => $half],
                'attr' => ['placeholder' => '0254 3 577 789', 'data-counter' => 60],
            ])
            ->add('email', TextField::class, [
                'label' => trans('plugins/restaurant::restaurant.email'),
                'wrapper' => ['class' => $half],
                'attr' => ['placeholder' => 'res@malibuhotel.com.vn', 'data-counter' => 120],
            ])
            ->add('rowClose1', 'html', ['html' => '</div>'])

            ->add('gallery_section', 'html', [
                'html' => '<div class="form-group">'
                    . '<label class="control-label">'
                    . trans('plugins/restaurant::restaurant.gallery')
                    . '</label>'
                    . '<p class="text-muted small mb-2">'
                    . trans('plugins/restaurant::restaurant.gallery_help')
                    . '</p>'
                    . view('plugins/restaurant::forms.gallery', ['model' => $this->getModel()])->render()
                    . '</div>',
                'wrapper' => ['class' => $this->formHelper->getConfig('defaults.wrapper_class')],
            ])
            ->add('vr360_url', TextField::class, [
                'label' => trans('plugins/restaurant::restaurant.vr360_url'),
                'attr' => ['placeholder' => 'https://...', 'data-counter' => 500],
                'help_block' => ['text' => trans('plugins/restaurant::restaurant.vr360_url_help')],
            ])

            ->add('content', EditorField::class, ContentFieldOption::make()->allowedShortcodes()->toArray())

            ->add('rowOpen2', 'html', ['html' => '<div class="row">'])
            ->add('is_featured', OnOffField::class, OnOffFieldOption::make()
                ->label(trans('core/base::forms.is_featured'))
                ->defaultValue(false)
                ->wrapperAttributes(['class' => $half])
                ->toArray())
            ->add('order', NumberField::class, SortOrderFieldOption::make()
                ->wrapperAttributes(['class' => $half])
                ->toArray())
            ->add('rowClose2', 'html', ['html' => '</div>'])

            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->setBreakFieldPoint('status');
    }
}
