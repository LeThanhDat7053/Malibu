@php
    $defaultLocale = \Botble\Language\Facades\Language::getDefaultLocaleCode();
    $refLang = \Botble\Language\Facades\Language::getCurrentAdminLocaleCode();
    $isTranslatedPage = $refLang && $refLang !== $defaultLocale && $refLang !== 'all';
    $createUrl = route('simple-slider-item.create', ['simple_slider_id' => BaseHelper::stringify($slider->id)]);

    if ($isTranslatedPage) {
        $createUrl .= '?' . http_build_query(['ref_lang' => $refLang]);
    }
@endphp

@if (! $isTranslatedPage)
    <x-core::button
        tag="a"
        data-bs-toggle="modal"
        data-bs-target="#simple-slider-item-modal"
        :href="$createUrl"
        icon="ti ti-plus"
    >
        {{ trans('plugins/simple-slider::simple-slider.add_new') }}
    </x-core::button>

    <x-core::button
        type="button"
        icon="ti ti-device-floppy"
        class="btn-save-sort-order"
        data-url="{{ route('simple-slider.sorting') }}"
        style="display: none;"
    >
        {{ trans('plugins/simple-slider::simple-slider.save_sorting') }}
    </x-core::button>
@endif
