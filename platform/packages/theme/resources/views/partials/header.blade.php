{!! SeoHelper::render() !!}
<link
    rel="sitemap"
    title="Sitemap"
    href="{{ rescue(fn() => route('public.sitemap'), report: false) }}"
    type="application/xml"
>

@php
    $themeFavicon = theme_option('favicon');
    $faviconUrl = $themeFavicon ? RvMedia::getImageUrl($themeFavicon) : asset('favicon.ico');
    $faviconExtension = strtolower(pathinfo(parse_url($faviconUrl, PHP_URL_PATH) ?: '', PATHINFO_EXTENSION));
    $faviconType = match ($faviconExtension) {
        'png' => 'image/png',
        'svg' => 'image/svg+xml',
        'gif' => 'image/gif',
        'jpg', 'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        default => 'image/x-icon',
    };
@endphp

<link rel="icon" href="{{ $faviconUrl }}" type="{{ $faviconType }}">
<link rel="shortcut icon" href="{{ $faviconUrl }}" type="{{ $faviconType }}">
<link rel="apple-touch-icon" href="{{ $faviconUrl }}">

@if (Theme::has('headerMeta'))
    {!! Theme::get('headerMeta') !!}
@endif

{!! apply_filters('theme_front_meta', null) !!}

{!! Theme::typography()->renderCssVariables() !!}

{!! Theme::asset()->container('before_header')->styles() !!}
{!! Theme::asset()->styles() !!}
{!! Theme::asset()->container('after_header')->styles() !!}
{!! Theme::asset()->container('header')->scripts() !!}

{!! apply_filters(THEME_FRONT_HEADER, null) !!}

{!! SeoHelper::meta()->getAnalytics()->render() !!}

<script>
    window.siteUrl = "{{ rescue(fn() => BaseHelper::getHomepageUrl()) }}";
</script>
