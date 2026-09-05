@extends(Theme::getThemeNamespace('layouts.base'))

@section('main')
    {{-- headerClass: view đặt 'mlb-header' để dùng navbar kiểu trang chủ mới --}}
    <header class="header-area header-three {{ Theme::get('headerClass', 'mlb-header') }}">
        @if (theme_option('header_top_enabled', true))
            {!! Theme::partial('header-top') !!}
        @endif

        {!! Theme::partial('header') !!}
    </header>

    {!! Theme::partial('booking-mask') !!}

    @if (Theme::get('breadcrumb', true))
        {!! Theme::partial('breadcrumbs') !!}
    @endif

    {!! Theme::content() !!}

    {!! Theme::partial('footer') !!}
@endsection
