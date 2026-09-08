@extends(Theme::getThemeNamespace('layouts.base'))

@section('main')
    {{-- nền trang đè lên footer, cuộn tới cuối mới nhả footer lộ ra --}}
    <div class="mlb-page">
    <header class="header-area header-three {{ Theme::get('headerClass', 'mlb-header') }}">
        @if (theme_option('header_top_enabled', true))
            {!! Theme::partial('header-top', ['fullWidth' => true]) !!}
        @endif

        {!! Theme::partial('header', ['fullWidth' => true]) !!}
    </header>

    {!! Theme::partial('booking-mask') !!}

    @if (Theme::get('breadcrumb', true))
    {!! Theme::partial('breadcrumbs') !!}
    @endif

    {!! Theme::content() !!}

    </div>

    {!! Theme::partial('footer') !!}
@endsection
