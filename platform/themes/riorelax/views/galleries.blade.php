@php
    Theme::layout('full-width');
    Theme::set('pageTitle', 'Galleries');
    Theme::set('breadcrumbPageKey', 'gallery');
    Theme::set('breadcrumb', true);
@endphp

<section class="section pt-60 pb-80">
    <div class="container">
        {!! Theme::partial('gallery.galleries', ['galleries' => $galleries]) !!}
    </div>
</section>
