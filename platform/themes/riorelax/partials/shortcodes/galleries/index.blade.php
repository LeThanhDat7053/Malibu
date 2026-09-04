<section class="section pb-100">
    <section class="profile fix pt-60">
        <div class="container-xxl">
            @if ($shortcode->subtitle || $shortcode->title || $shortcode->description)
                <div class="mlb-section-head">
                    @if ($subtitle = $shortcode->subtitle)
                        <p class="mlb-eyebrow">{{ $subtitle }}</p>
                    @endif

                    @if ($title = $shortcode->title)
                        <h2 class="mlb-display">{!! BaseHelper::clean($title) !!}</h2>
                    @endif

                    @if ($description = $shortcode->description)
                        <p class="mlb-lede">{!! BaseHelper::clean($description) !!}</p>
                    @endif
                </div>
            @endif

            {!! Theme::partial('gallery.galleries', ['galleries' => $galleries]) !!}
        </div>
    </section>
</section>
