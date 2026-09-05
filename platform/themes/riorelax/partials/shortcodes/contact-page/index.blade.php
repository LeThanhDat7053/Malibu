{{--
    Trang liên hệ theo bố cục Himara: cột trái tiêu đề + mô tả + form,
    cột phải bản đồ, danh sách thông tin liên hệ và mạng xã hội.
    Mọi nội dung đọc từ thuộc tính shortcode nên sửa chữ không đụng bố cục.
--}}
@php
    $infoItems = collect([
        ['icon' => 'fal fa-map-marker-alt', 'value' => $shortcode->address, 'url' => null],
        ['icon' => 'fal fa-phone', 'value' => $shortcode->phone, 'url' => $shortcode->phone ? 'tel:' . preg_replace('/\D+/', '', $shortcode->phone) : null],
        ['icon' => 'fal fa-headset', 'value' => $shortcode->hotline, 'url' => $shortcode->hotline ? 'tel:' . preg_replace('/\D+/', '', $shortcode->hotline) : null],
        ['icon' => 'fal fa-envelope', 'value' => $shortcode->email, 'url' => $shortcode->email ? 'mailto:' . $shortcode->email : null],
        ['icon' => 'fal fa-globe', 'value' => $shortcode->website, 'url' => $shortcode->website ? (str_starts_with($shortcode->website, 'http') ? $shortcode->website : 'https://' . $shortcode->website) : null],
    ])->filter(fn ($item) => filled($item['value']))->values();

    $showSocial = $shortcode->show_social !== '0';
    $socialLinks = $showSocial ? json_decode(theme_option('social_links')) : null;
@endphp

<section class="mlb-contact">
    <div class="mlb-shell mlb-contact__grid">
        <div class="mlb-contact__main">
            @if ($subtitle = $shortcode->subtitle)
                <p class="mlb-eyebrow">{{ $subtitle }}</p>
            @endif

            @if ($title = $shortcode->title)
                <h2 class="mlb-display mlb-display--sm">{{ $title }}</h2>
            @endif

            @if ($description = $shortcode->description)
                <p class="mlb-lede">{{ $description }}</p>
            @endif

            <div class="mlb-contact__form">
                {!! $form->renderForm() !!}
            </div>
        </div>

        <aside class="mlb-contact__aside">
            @php
                $mapEmbed = $shortcode->map_embed;
                $vr360 = $shortcode->vr360_url;
                // chỉ có cả hai mới cần nút chuyển đổi
                $canToggle = $mapEmbed && $vr360;
                $mapTitle = $shortcode->info_title ?: theme_option('site_title');
            @endphp

            @if ($mapEmbed || $vr360)
                <div class="mlb-contact__map" @if ($canToggle) data-mlb-map @endif>
                    <div class="mlb-contact__map-stage">
                        @if ($mapEmbed)
                            <div class="mlb-contact__map-pane is-active" data-mlb-map-pane="map">
                                <iframe src="{{ $mapEmbed }}" loading="lazy" allowfullscreen
                                        referrerpolicy="no-referrer-when-downgrade"
                                        title="{{ $mapTitle }}"></iframe>
                            </div>
                        @endif

                        @if ($vr360)
                            {{-- src để trống, chỉ nạp tour khi bấm nút cho nhẹ trang --}}
                            <div class="mlb-contact__map-pane {{ $mapEmbed ? '' : 'is-active' }}" data-mlb-map-pane="vr">
                                <iframe @if ($mapEmbed) data-src="{{ $vr360 }}" @else src="{{ $vr360 }}" @endif
                                        loading="lazy" allowfullscreen
                                        title="{{ $mapTitle }} VR360"></iframe>
                            </div>
                        @endif
                    </div>

                    @if ($canToggle)
                        <button type="button" class="mlb-contact__map-toggle" data-mlb-map-toggle
                                title="{{ trans('plugins/restaurant::restaurant.view_vr360') }}"
                                aria-label="{{ trans('plugins/restaurant::restaurant.view_vr360') }}">
                            <i class="fal fa-vr-cardboard" data-mlb-map-icon></i>
                        </button>
                    @endif
                </div>
            @endif

            <div class="mlb-contact__info">
                @if ($infoTitle = $shortcode->info_title)
                    <h3 class="mlb-contact__info-title">{{ $infoTitle }}</h3>
                @endif

                @if ($infoItems->isNotEmpty())
                    <ul class="mlb-contact__list">
                        @foreach ($infoItems as $item)
                            <li>
                                <i class="{{ $item['icon'] }}"></i>
                                @if ($item['url'])
                                    <a href="{{ $item['url'] }}">{{ $item['value'] }}</a>
                                @else
                                    <span>{!! nl2br(e($item['value'])) !!}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($socialLinks)
                    <div class="mlb-contact__social">
                        @foreach ($socialLinks as $social)
                            @php($social = collect($social)->pluck('value', 'key'))
                            <a href="{{ $social->get('url') }}" target="_blank" rel="noopener"
                               title="{{ $social->get('name') }}">
                                <i class="{{ $social->get('social-icon') }}"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </aside>
    </div>
</section>

@if (($shortcode->map_embed) && ($shortcode->vr360_url))
    <script>
        (function () {
            var root = document.querySelector('[data-mlb-map]');

            if (!root) {
                return;
            }

            var button = root.querySelector('[data-mlb-map-toggle]');
            var icon = root.querySelector('[data-mlb-map-icon]');

            button.addEventListener('click', function () {
                var panes = root.querySelectorAll('[data-mlb-map-pane]');
                var showingVr = false;

                panes.forEach(function (pane) {
                    var active = !pane.classList.contains('is-active');
                    pane.classList.toggle('is-active', active);

                    if (active && pane.getAttribute('data-mlb-map-pane') === 'vr') {
                        showingVr = true;

                        // nạp tour ở lần bấm đầu tiên
                        var frame = pane.querySelector('iframe');

                        if (frame && !frame.src && frame.dataset.src) {
                            frame.src = frame.dataset.src;
                        }
                    }
                });

                icon.className = showingVr ? 'fal fa-map-marked-alt' : 'fal fa-vr-cardboard';
                root.classList.toggle('is-vr', showingVr);
            });
        })();
    </script>
@endif
