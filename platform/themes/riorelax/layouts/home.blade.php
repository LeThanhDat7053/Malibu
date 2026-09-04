@extends(Theme::getThemeNamespace('layouts.base'))

{{-- Homepage layout: content scoped under .mlb-home so the editorial restyle stays on this page --}}
@section('main')
    <header class="header-area header-three mlb-header">
        @if (theme_option('header_top_enabled', true))
            {!! Theme::partial('header-top') !!}
        @endif

        {!! Theme::partial('header') !!}
    </header>

    {{-- floating booking bar: home.js keeps it hidden while the in-page
         [booking-strip] is on screen, so the two never overlap --}}
    {!! Theme::partial('booking-mask') !!}

    <main class="mlb-home">
        {!! Theme::content() !!}
    </main>

    {!! Theme::partial('footer') !!}
@endsection
