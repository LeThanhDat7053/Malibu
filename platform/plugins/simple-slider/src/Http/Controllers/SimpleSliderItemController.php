<?php

namespace Botble\SimpleSlider\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Language\Facades\Language;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\SimpleSlider\Forms\SimpleSliderItemForm;
use Botble\SimpleSlider\Http\Requests\SimpleSliderItemRequest;
use Botble\SimpleSlider\Models\SimpleSliderItem;
use Botble\SimpleSlider\Tables\SimpleSliderItemTable;
use Botble\Translation\AutoTranslateManager;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SimpleSliderItemController extends BaseController
{
    protected function syncLanguageContext(): ?string
    {
        $refLang = request()->input('ref_lang')
            ?: Language::getCurrentAdminLocaleCode()
            ?: Language::getDefaultLocaleCode();

        Language::setCurrentAdminLocale($refLang);
        LanguageAdvancedManager::clearLocaleCache();
        LanguageAdvancedManager::initModelRelations();

        return $refLang;
    }

    public function index(SimpleSliderItemTable $dataTable)
    {
        $this->syncLanguageContext();

        return $dataTable->renderTable();
    }

    public function create()
    {
        $this->syncLanguageContext();

        $form = SimpleSliderItemForm::create()
            ->setRequest(request())
            ->setUseInlineJs(true)
            ->renderForm();

        return $this
            ->httpResponse()
            ->setData([
                'title' => trans('plugins/simple-slider::simple-slider.create_new_slide'),
                'content' => $form,
                'canApplyAll' => false,
            ]);
    }

    public function store(SimpleSliderItemRequest $request)
    {
        SimpleSliderItemForm::create()->setRequest($request)->save();

        return $this
            ->httpResponse()
            ->withCreatedSuccessMessage();
    }

    public function edit(int|string $id)
    {
        $refLang = $this->syncLanguageContext();

        $simpleSliderItem = SimpleSliderItem::query()
            ->when($refLang, function ($query) use ($refLang): void {
                $query->with([
                    'translations' => fn ($query) => $query->where('lang_code', $refLang),
                ]);
            })
            ->findOrFail($id);

        $form = SimpleSliderItemForm::createFromModel($simpleSliderItem)
            ->setRequest(request())
            ->setUseInlineJs(true)
            ->renderForm();

        return $this
            ->httpResponse()
            ->setData([
                'title' => trans('plugins/simple-slider::simple-slider.edit_slide', ['id' => $simpleSliderItem->getKey()]),
                'content' => $form,
                'canApplyAll' => true,
                'applyAllConfirmMessage' => trans('plugins/simple-slider::simple-slider.apply_to_all_confirm'),
                'aiTranslateAllConfirmMessage' => trans('plugins/simple-slider::simple-slider.ai_translate_all_confirm'),
            ]);
    }

    public function update(int|string $id, SimpleSliderItemRequest $request)
    {
        $simpleSliderItem = SimpleSliderItem::query()->findOrFail($id);

        SimpleSliderItemForm::createFromModel($simpleSliderItem)
            ->setRequest($request)
            ->save();

        if ($request->boolean('apply_all')) {
            $this->applyTitleAndDescriptionToSiblingItems(
                $simpleSliderItem,
                $request->input('language'),
                $request->input('title'),
                $request->input('description')
            );

            return $this
                ->httpResponse()
                ->setMessage(trans('plugins/simple-slider::simple-slider.apply_to_all_success'));
        }

        if ($request->boolean('ai_translate_all')) {
            $this->aiTranslateTitleAndDescriptionToSiblingItems(
                $simpleSliderItem,
                $request->input('language'),
                $request->input('title'),
                $request->input('description')
            );

            return $this
                ->httpResponse()
                ->setMessage(trans('plugins/simple-slider::simple-slider.ai_translate_all_success'));
        }

        return $this
            ->httpResponse()
            ->withUpdatedSuccessMessage();
    }

    public function applyAll(int|string $id)
    {
        $simpleSliderItem = SimpleSliderItem::query()->findOrFail($id);

        $validated = Validator::make(request()->all(), [
            'simple_slider_id' => ['required', 'integer'],
            'language' => ['nullable', 'string', 'max:20'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ])->validate();

        if ((int) $validated['simple_slider_id'] !== (int) $simpleSliderItem->simple_slider_id) {
            abort(422, 'The selected slider item does not belong to this slider.');
        }

        $this->applyTitleAndDescriptionToSiblingItems(
            $simpleSliderItem,
            $validated['language'] ?? null,
            $validated['title'] ?? null,
            $validated['description'] ?? null
        );

        return $this
            ->httpResponse()
            ->setMessage(trans('plugins/simple-slider::simple-slider.apply_to_all_success'));
    }

    protected function applyTitleAndDescriptionToSiblingItems(
        SimpleSliderItem $simpleSliderItem,
        ?string $language,
        ?string $title,
        ?string $description
    ): void {
        $language = $language ?: Language::getCurrentAdminLocaleCode() ?: Language::getDefaultLocaleCode();
        $defaultLanguage = Language::getDefaultLocaleCode();

        $targetItems = SimpleSliderItem::query()
            ->select(['id', 'link'])
            ->where('simple_slider_id', $simpleSliderItem->simple_slider_id)
            ->get();

        DB::transaction(function () use ($targetItems, $language, $defaultLanguage, $title, $description): void {
            if ($targetItems->isEmpty()) {
                return;
            }

            if ($language === $defaultLanguage) {
                $itemIds = $targetItems->pluck('id')->all();

                SimpleSliderItem::query()
                    ->whereIn('id', $itemIds)
                    ->update([
                        'title' => $title,
                        'description' => $description,
                    ]);

                $activeLanguageCodes = DB::table('languages')
                    ->pluck('lang_code')
                    ->filter()
                    ->unique()
                    ->values();

                $existingTranslationLinks = DB::table('simple_slider_items_translations')
                    ->whereIn('simple_slider_items_id', $itemIds)
                    ->get(['simple_slider_items_id', 'lang_code', 'link'])
                    ->keyBy(fn ($item) => $item->simple_slider_items_id . '|' . $item->lang_code);

                foreach ($targetItems as $targetItem) {
                    foreach ($activeLanguageCodes as $langCode) {
                        $existingTranslation = $existingTranslationLinks->get($targetItem->id . '|' . $langCode);

                        DB::table('simple_slider_items_translations')->updateOrInsert(
                            [
                                'lang_code' => $langCode,
                                'simple_slider_items_id' => $targetItem->id,
                            ],
                            [
                                'title' => $title,
                                'description' => $description,
                                'link' => $existingTranslation?->link ?: $targetItem->link,
                            ]
                        );
                    }
                }

                return;
            }

            $existingTranslations = DB::table('simple_slider_items_translations')
                ->where('lang_code', $language)
                ->whereIn('simple_slider_items_id', $targetItems->pluck('id')->all())
                ->pluck('link', 'simple_slider_items_id');

            foreach ($targetItems as $targetItem) {
                DB::table('simple_slider_items_translations')->updateOrInsert(
                    [
                        'lang_code' => $language,
                        'simple_slider_items_id' => $targetItem->id,
                    ],
                    [
                        'title' => $title,
                        'description' => $description,
                        'link' => $existingTranslations->get($targetItem->id) ?: $targetItem->link,
                    ]
                );
            }
        });
    }

    protected function aiTranslateTitleAndDescriptionToSiblingItems(
        SimpleSliderItem $simpleSliderItem,
        ?string $language,
        ?string $title,
        ?string $description
    ): void {
        if (! class_exists(AutoTranslateManager::class)) {
            abort(422, trans('plugins/simple-slider::simple-slider.ai_translate_unavailable'));
        }

        $language = $language ?: Language::getCurrentAdminLocaleCode() ?: Language::getDefaultLocaleCode();
        $defaultLanguage = Language::getDefaultLocaleCode();

        $languages = DB::table('languages')
            ->select(['lang_code', 'lang_locale'])
            ->get()
            ->filter(fn ($item) => ! empty($item->lang_code) && ! empty($item->lang_locale))
            ->keyBy('lang_code');

        $sourceLocale = $languages->get($language)?->lang_locale;

        if (! $sourceLocale) {
            abort(422, trans('plugins/simple-slider::simple-slider.ai_translate_unavailable'));
        }

        $targetItems = SimpleSliderItem::query()
            ->select(['id', 'link'])
            ->where('simple_slider_id', $simpleSliderItem->simple_slider_id)
            ->get();

        if ($targetItems->isEmpty()) {
            return;
        }

        $translator = app(AutoTranslateManager::class);
        $existingTranslationLinks = DB::table('simple_slider_items_translations')
            ->whereIn('simple_slider_items_id', $targetItems->pluck('id')->all())
            ->get(['simple_slider_items_id', 'lang_code', 'link'])
            ->keyBy(fn ($item) => $item->simple_slider_items_id . '|' . $item->lang_code);

        $translatedByLanguage = [];

        foreach ($languages as $langCode => $lang) {
            if ($langCode === $language) {
                continue;
            }

            try {
                $translatedByLanguage[$langCode] = [
                    'title' => $title ? $translator->translate($sourceLocale, $lang->lang_locale, $title) : $title,
                    'description' => $description ? $translator->translate($sourceLocale, $lang->lang_locale, $description) : $description,
                ];
            } catch (Throwable) {
                $translatedByLanguage[$langCode] = [
                    'title' => $title,
                    'description' => $description,
                ];
            }
        }

        DB::transaction(function () use (
            $targetItems,
            $language,
            $defaultLanguage,
            $title,
            $description,
            $translatedByLanguage,
            $existingTranslationLinks
        ): void {
            $itemIds = $targetItems->pluck('id')->all();

            if ($language === $defaultLanguage) {
                SimpleSliderItem::query()
                    ->whereIn('id', $itemIds)
                    ->update([
                        'title' => $title,
                        'description' => $description,
                    ]);
            } else {
                foreach ($targetItems as $targetItem) {
                    DB::table('simple_slider_items_translations')->updateOrInsert(
                        [
                            'lang_code' => $language,
                            'simple_slider_items_id' => $targetItem->id,
                        ],
                        [
                            'title' => $title,
                            'description' => $description,
                            'link' => $existingTranslationLinks->get($targetItem->id . '|' . $language)?->link ?: $targetItem->link,
                        ]
                    );
                }
            }

            foreach ($translatedByLanguage as $langCode => $translated) {
                if ($langCode === $defaultLanguage) {
                    SimpleSliderItem::query()
                        ->whereIn('id', $itemIds)
                        ->update([
                            'title' => $translated['title'],
                            'description' => $translated['description'],
                        ]);
                }

                foreach ($targetItems as $targetItem) {
                    DB::table('simple_slider_items_translations')->updateOrInsert(
                        [
                            'lang_code' => $langCode,
                            'simple_slider_items_id' => $targetItem->id,
                        ],
                        [
                            'title' => $translated['title'],
                            'description' => $translated['description'],
                            'link' => $existingTranslationLinks->get($targetItem->id . '|' . $langCode)?->link ?: $targetItem->link,
                        ]
                    );
                }
            }
        });
    }

    public function destroy(int|string $id)
    {
        $simpleSliderItem = SimpleSliderItem::query()->findOrFail($id);

        return DeleteResourceAction::make($simpleSliderItem);
    }
}
