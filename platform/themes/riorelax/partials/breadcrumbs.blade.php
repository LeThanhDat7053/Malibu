{{--
    Banner dùng chung cho mọi trang (thư viện ảnh, tin tức, liên hệ, tìm kiếm…).
    Dựng theo .mlb-rd-hero của trang Phòng để cả site cùng một kiểu banner:
    ảnh nền phủ lớp tối, tiêu đề trang và breadcrumb đè lên, navbar mờ nằm trên.
--}}
@php
    $breadcrumbPageKey = Theme::get('breadcrumbPageKey');
    $breadcrumbOptionMap = [
        'room' => 'breadcrumb_background_image_room',
        'product' => 'breadcrumb_background_image_product',
        'gallery' => 'breadcrumb_background_image_gallery',
        'blog' => 'breadcrumb_background_image_blog',
    ];

    $breadcrumbBackgroundImage = Theme::get('breadcrumbBackgroundImage');

    if (! $breadcrumbBackgroundImage && $breadcrumbPageKey && isset($breadcrumbOptionMap[$breadcrumbPageKey])) {
        $breadcrumbBackgroundImage = theme_option($breadcrumbOptionMap[$breadcrumbPageKey]);
    }

    $breadcrumbBackgroundImage = $breadcrumbBackgroundImage ?: theme_option('breadcrumb_background_image');
    $bgImage = $breadcrumbBackgroundImage ? RvMedia::getImageUrl($breadcrumbBackgroundImage) : Theme::asset()->url('images/breadcrumb-bg.jpg');

    $crumbs = collect(Theme::breadcrumb()->getCrumbs());
@endphp

<section class="mlb-rd-hero mlb-page-hero" style="background-image: url('{{ $bgImage }}');">
    <div class="mlb-shell mlb-rd-hero__inner">
        <div class="mlb-rd-hero__head">
            <div class="mlb-rd-hero__id">
                @if ($pageTitle = Theme::get('pageTitle'))
                    <h1 class="mlb-rd-hero__title">{!! BaseHelper::clean($pageTitle) !!}</h1>
                @endif
            </div>
        </div>

        @if ($crumbs->count() > 1)
            <nav aria-label="breadcrumb">
                <ol class="mlb-rd-crumbs">
                    @foreach ($crumbs as $crumb)
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
