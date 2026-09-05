@php
    Theme::layout('full-width');
    // Navbar lấy theo trang chủ mới, dải tiêu đề tự dựng nên tắt breadcrumb dùng chung
    Theme::set('headerClass', 'mlb-header');
    Theme::set('pageTitle', __('Rooms'));
    Theme::set('breadcrumbPageKey', 'room');
    Theme::set('breadcrumb', false);

    $heroImageOption = theme_option('breadcrumb_background_image_room') ?: theme_option('breadcrumb_background_image');
    $heroImage = $heroImageOption
        ? RvMedia::getImageUrl($heroImageOption)
        : Theme::asset()->url('images/breadcrumb-bg.jpg');

    $roomCrumbs = collect(Theme::breadcrumb()->getCrumbs());
@endphp

<div class="mlb-page mlb-rooms-page">
    <section class="mlb-rd-hero" style="background-image: url('{{ $heroImage }}');">
        <div class="mlb-shell mlb-rd-hero__inner">
            <div class="mlb-rd-hero__head">
                <div class="mlb-rd-hero__id">
                    <h1 class="mlb-rd-hero__title">{{ __('Rooms') }}</h1>
                </div>
            </div>

            @if ($roomCrumbs->count() > 1)
                <nav aria-label="breadcrumb">
                    <ol class="mlb-rd-crumbs">
                        @foreach ($roomCrumbs as $crumb)
                            @if (! $loop->last)
                                <li><a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a></li>
                            @else
                                <li aria-current="page">{{ $crumb['label'] }}</li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            @endif
        </div>
    </section>

    <div class="mlb-shell mlb-rd-body">
        <div class="mlb-rd-main">
            <div class="mlb-rd-content">
                {!! do_shortcode('[all-rooms]') !!}
            </div>

            <aside class="mlb-rd-aside">
                <div class="mlb-rd-aside__inner">
                    {!! dynamic_sidebar('rooms_sidebar') !!}
                </div>
            </aside>
        </div>
    </div>
</div>
