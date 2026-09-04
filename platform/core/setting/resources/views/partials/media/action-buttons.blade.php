@extends('core/setting::forms.partials.action')

@section('content')
    <x-core::button
        tag="a"
        type="button"
        color="info"
        href="{{ route('settings.media.resize-images') }}"
    >
        Resize old media images
    </x-core::button>

    <x-core::button
        type="button"
        color="warning"
        class="generate-thumbnails-trigger-button"
    >
        {{ trans('core/setting::setting.generate_thumbnails') }}
    </x-core::button>
@stop
