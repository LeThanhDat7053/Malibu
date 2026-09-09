@php
    Theme::set('pageTitle',  $gallery->name);
    Theme::set('breadcrumbPageKey', 'gallery');
@endphp

@if (function_exists('get_galleries'))
    <div class="container mt-50 mb-50">
        <h6 class="custom-gallery-description text-center">{!! BaseHelper::clean($gallery->description) !!}</h6>
        <div class="row mt-50">
            <article class="post post--single">
                <div class="post__content">
                    {{-- Ảnh + video + VR360 dùng chung partial media-gallery --}}
                    {!! Theme::partial('media-gallery', [
                        'items' => gallery_meta_data($gallery),
                        'id' => 'list-photo',
                    ]) !!}
                </div>
            </article>
        </div>
    </div>
@endif
