<?php

namespace Botble\SimpleSlider\Forms;

use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\SortOrderFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Language\Facades\Language;
use Botble\SimpleSlider\Http\Requests\SimpleSliderItemRequest;
use Botble\SimpleSlider\Models\SimpleSliderItem;
use Illuminate\Support\Facades\DB;

class SimpleSliderItemForm extends FormAbstract
{
    public function setup(): void
    {
        $this->model(SimpleSliderItem::class);

        $model = $this->getModel();
        $request = $this->getRequest();
        $defaultLanguage = Language::getDefaultLocaleCode();
        $currentLanguage = $request->query('ref_lang')
            ?: $request->input('ref_lang')
            ?: $request->input('language')
            ?: Language::getCurrentAdminLocaleCode()
            ?: $defaultLanguage;

        $title = $model->exists ? $model->getRawOriginal('title') : $model->title;
        $link = $model->exists ? $model->getRawOriginal('link') : $model->link;
        $description = $model->exists ? $model->getRawOriginal('description') : $model->description;

        if ($model->exists && $currentLanguage !== $defaultLanguage) {
            $translation = $model->relationLoaded('translations')
                ? $model->translations->firstWhere('lang_code', $currentLanguage)
                : null;

            if (! $translation) {
                $translation = DB::table('simple_slider_items_translations')
                    ->where('lang_code', $currentLanguage)
                    ->where('simple_slider_items_id', $model->getKey())
                    ->first();
            }

            if ($translation) {
                $title = $translation->title;
                $link = $translation->link;
                $description = $translation->description;
            }
        }

        if (
            $model->exists &&
            $currentLanguage === $defaultLanguage &&
            (! $description || ! $title || ! $link)
        ) {
            $defaultTranslation = DB::table('simple_slider_items_translations')
                ->where('lang_code', $defaultLanguage)
                ->where('simple_slider_items_id', $model->getKey())
                ->first();

            if ($defaultTranslation) {
                $title = $title ?: $defaultTranslation->title;
                $link = $link ?: $defaultTranslation->link;
                $description = $description ?: $defaultTranslation->description;
            }
        }

        // Update model attributes with resolved values so that form extension
        // hooks (e.g. theme hooks that re-add fields) read the correct data.
        if ($model->exists) {
            $model->setAttribute('title', $title);
            $model->setAttribute('link', $link);
            $model->setAttribute('description', $description);
        }

        $debugInfo = json_encode([
            'currentLang' => $currentLanguage,
            'defaultLang' => $defaultLanguage,
            'resolved_title' => $title,
            'resolved_desc' => $description,
            'model_id' => $model->getKey(),
        ]);

        $this
            ->setValidatorClass(SimpleSliderItemRequest::class)
            ->contentOnly()
            ->add('_debug_info', 'hidden', ['value' => $debugInfo])
            ->add('language', 'hidden', ['value' => $currentLanguage])
            ->add('simple_slider_id', 'hidden', [
                'value' => $model->simple_slider_id ?: $this->getRequest()->input('simple_slider_id'),
            ])
            ->add('title', TextField::class, [
                'label' => trans('core/base::forms.title'),
                'attr' => [
                    'id' => 'simple_slider_item_title',
                    'data-counter' => 120,
                ],
                'value' => $title,
            ])
            ->add('link', TextField::class, [
                'label' => trans('core/base::forms.link'),
                'attr' => [
                    'id' => 'simple_slider_item_link',
                    'placeholder' => 'https://',
                    'data-counter' => 120,
                ],
                'value' => $link,
            ])
            ->add('description', TextareaField::class, DescriptionFieldOption::make()->value($description)->addAttribute('id', 'simple_slider_item_description'))
            ->add('order', NumberField::class, SortOrderFieldOption::make()->addAttribute('id', 'simple_slider_item_order'))
            ->add('image', MediaImageField::class, MediaImageFieldOption::make()->required());
    }
}
