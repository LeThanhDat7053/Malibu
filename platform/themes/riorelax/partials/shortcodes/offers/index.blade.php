{{-- Offers & stay packages, pulled from a blog category so marketing can publish them as posts --}}
<section class="mlb-offers">
    <div class="mlb-shell">
        <div class="mlb-section-head mlb-section-head--split">
            <div>
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

            @if (($buttonLabel = $shortcode->button_label) && ($buttonUrl = $shortcode->button_url))
                <a class="mlb-btn mlb-btn--ghost" href="{{ $buttonUrl }}">{{ $buttonLabel }}</a>
            @endif
        </div>

        <div class="mlb-offers__grid">
            @foreach ($posts as $post)
                <article class="mlb-offer">
                    <a class="mlb-offer__media" href="{{ $post->url }}">
                        @if ($image = $post->image)
                            <img src="{{ RvMedia::getImageUrl($image, 'medium') }}" alt="{{ $post->name }}" loading="lazy">
                        @endif
                    </a>

                    <div class="mlb-offer__body">
                        @if ($category = $post->firstCategory)
                            <p class="mlb-eyebrow mlb-eyebrow--sm">{{ $category->name }}</p>
                        @endif

                        <h3 class="mlb-offer__title"><a href="{{ $post->url }}">{{ $post->name }}</a></h3>

                        @if ($post->description)
                            <p class="mlb-offer__text">{{ Str::limit(strip_tags($post->description), 130) }}</p>
                        @endif

                        <a class="mlb-link" href="{{ $post->url }}">{{ $shortcode->item_label ?: __('View offer') }}</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
