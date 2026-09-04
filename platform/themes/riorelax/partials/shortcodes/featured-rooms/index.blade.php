@php($style = $shortcode->style === 'editorial' ? 'editorial' : 'default')

@if ($style === 'editorial')
    <section class="mlb-rooms">
        <div class="mlb-shell">
            <div class="mlb-section-head">
                @if ($subtitle = $shortcode->subtitle)
                    <p class="mlb-eyebrow">{!! BaseHelper::clean($subtitle) !!}</p>
                @endif

                @if ($title = $shortcode->title)
                    <h2 class="mlb-display">{!! BaseHelper::clean($title) !!}</h2>
                @endif

                @if ($description = $shortcode->description)
                    <p class="mlb-lede">{!! BaseHelper::clean($description) !!}</p>
                @endif
            </div>

            <div class="mlb-rooms__grid">
                @foreach ($rooms as $room)
                    {!! Theme::partial('rooms.item-editorial', compact('room', 'startDate', 'endDate', 'nights', 'adults')) !!}
                @endforeach
            </div>

            @if (($buttonLabel = $shortcode->button_label) && ($buttonUrl = $shortcode->button_url))
                <div class="mlb-rooms__foot">
                    <a class="mlb-btn mlb-btn--ghost" href="{{ $buttonUrl }}">{{ $buttonLabel }}</a>
                </div>
            @endif
        </div>
    </section>
@else
    <section class="services-area pt-90 pb-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="section-title center-align mb-50 text-center">
                        @if ($subtitle = $shortcode->subtitle)
                            <h5>{!! BaseHelper::clean($subtitle) !!}</h5>
                        @endif

                        @if ($title = $shortcode->title)
                            <h2>{!! BaseHelper::clean($title) !!}</h2>
                        @endif

                        @if ($description = $shortcode->description)
                            <p>{!! BaseHelper::clean($description) !!}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row services-active">
                @foreach($rooms as $room)
                    <div class="col-xl-4 col-md-6">
                        @php($margin = true)
                        {!! Theme::partial('rooms.item', compact('room', 'startDate', 'endDate', 'nights', 'adults', 'margin')) !!}
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
