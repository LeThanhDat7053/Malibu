@if (isset($galleries) && !$galleries->isEmpty())

@php
    // Chuẩn hoá 1 item trong gallery_meta thành dữ liệu render + dữ liệu lightbox.
    // Item lưu trong DB: ['img' => url|path, 'description' => '', 'type' => 'image|video|vr360', 'thumb' => url]
    $resolveMediaUrl = function ($value) {
        if (empty($value)) {
            return null;
        }

        return str_starts_with($value, 'http://') || str_starts_with($value, 'https://') || str_starts_with($value, '//')
            ? $value
            : RvMedia::getImageUrl($value);
    };

    $buildGalleryItem = function (array $image) use ($resolveMediaUrl) {
        $src = \Illuminate\Support\Arr::get($image, 'img');

        if (empty($src)) {
            return null;
        }

        $type = \Illuminate\Support\Arr::get($image, 'type', 'image') ?: 'image';
        $desc = BaseHelper::clean((string) \Illuminate\Support\Arr::get($image, 'description', ''));
        $thumb = $resolveMediaUrl(\Illuminate\Support\Arr::get($image, 'thumb'));

        if ($type === 'video') {
            $ytId = $vimeoId = null;

            if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $src, $m)) {
                $ytId = $m[1];
            } elseif (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $src, $m)) {
                $vimeoId = $m[1];
            }

            if ($ytId) {
                return [
                    'kind' => 'video',
                    'lbType' => 'iframe',
                    'lbSrc' => 'https://www.youtube.com/embed/' . $ytId . '?autoplay=1&rel=0',
                    'link' => $src,
                    'thumb' => $thumb ?: 'https://img.youtube.com/vi/' . $ytId . '/hqdefault.jpg',
                    'desc' => $desc,
                ];
            }

            if ($vimeoId) {
                return [
                    'kind' => 'video',
                    'lbType' => 'iframe',
                    'lbSrc' => 'https://player.vimeo.com/video/' . $vimeoId . '?autoplay=1',
                    'link' => $src,
                    'thumb' => $thumb,
                    'desc' => $desc,
                ];
            }

            // File video tải lên (mp4/webm...)
            return [
                'kind' => 'video',
                'lbType' => 'video',
                'lbSrc' => $resolveMediaUrl($src),
                'link' => $resolveMediaUrl($src),
                'thumb' => $thumb,
                'desc' => $desc,
            ];
        }

        if ($type === 'vr360') {
            $link = $resolveMediaUrl($src);
            // Không có ảnh đại diện riêng: nếu link chính là ảnh panorama thì dùng luôn làm thumbnail
            $isImageLink = (bool) preg_match('/\.(jpe?g|png|webp|gif|avif)(\?.*)?$/i', (string) $link);

            return [
                'kind' => 'vr360',
                'lbType' => 'iframe',
                'lbSrc' => $link,
                'link' => $link,
                'thumb' => $thumb ?: ($isImageLink ? $link : null),
                'desc' => $desc,
            ];
        }

        return [
            'kind' => 'image',
            'lbType' => 'image',
            'lbSrc' => RvMedia::getImageUrl($src),
            'link' => RvMedia::getImageUrl($src),
            'thumb' => RvMedia::getImageUrl($src, 'medium'),
            'desc' => $desc,
        ];
    };
@endphp

{{-- Tab Navigation --}}
<div class="gallery-tab-scroll-wrap">
<ul class="nav nav-tabs gallery-nav-tabs mb-0" id="galleryTabNav" role="tablist">
    @foreach ($galleries as $gallery)
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                    id="gtab-btn-{{ $gallery->id }}"
                    data-bs-toggle="tab"
                    data-bs-target="#gtab-pane-{{ $gallery->id }}"
                    type="button"
                    role="tab"
                    aria-controls="gtab-pane-{{ $gallery->id }}"
                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                {{ $gallery->name }}
            </button>
        </li>
    @endforeach
</ul>
</div>

{{-- Tab Content --}}
<div class="tab-content" id="galleryTabContent">
    @foreach ($galleries as $gallery)
        @php
            $rawItems = function_exists('gallery_meta_data') ? gallery_meta_data($gallery) : [];
            $items = [];
            foreach ($rawItems as $rawItem) {
                if (! is_array($rawItem)) {
                    continue;
                }
                $built = $buildGalleryItem($rawItem);
                if ($built) {
                    $items[] = $built;
                }
            }
        @endphp
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
             id="gtab-pane-{{ $gallery->id }}"
             role="tabpanel"
             aria-labelledby="gtab-btn-{{ $gallery->id }}">
            <div class="row listGalleryItem">
                @forelse ($items as $idx => $item)
                    <div class="col-6 col-md-4 col-lg-3 colItem mb-3"
                         data-gallery-id="{{ $gallery->id }}"
                         data-idx="{{ $idx }}"
                         data-lb-type="{{ $item['lbType'] }}"
                         data-lb-kind="{{ $item['kind'] }}"
                         data-lb-src="{{ $item['lbSrc'] }}"
                         data-lb-link="{{ $item['link'] }}"
                         data-lb-desc="{{ $item['desc'] }}"
                         title="{{ $item['desc'] }}"
                         style="cursor:pointer;">
                        <div class="wrapImgResize img3And2 gallery-tile gallery-tile--{{ $item['kind'] }}">
                            @if ($item['thumb'])
                                <img src="{{ $item['thumb'] }}"
                                     alt="{{ $item['desc'] ?: $gallery->name }}"
                                     loading="lazy"
                                     @if ($item['kind'] !== 'image') onerror="this.style.display='none'" @endif>
                            @endif

                            @if ($item['kind'] === 'video')
                                <span class="gallery-tile-icon"><i class="fas fa-play"></i></span>
                                <span class="gallery-tile-badge gallery-tile-badge--video">
                                    <i class="fas fa-video"></i> VIDEO
                                </span>
                            @elseif ($item['kind'] === 'vr360')
                                <span class="gallery-tile-icon gallery-tile-icon--vr"><i class="fas fa-vr-cardboard"></i></span>
                                <span class="gallery-tile-badge gallery-tile-badge--vr">
                                    <i class="fas fa-street-view"></i> VR360
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-4">{{ __('No images available.') }}</div>
                @endforelse
            </div>
        </div>
    @endforeach
</div>

{{-- Lightbox --}}
<div id="gallery-lightbox"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.92); z-index:9999; align-items:center; justify-content:center;"
     onclick="glbClose(event)">
    <div id="gallery-lb-stage"
         style="width:92vw; height:84vh; display:flex; align-items:center; justify-content:center;"
         onclick="glbClose(event)">
        <img id="gallery-lb-img"
             src="" alt=""
             style="max-width:100%; max-height:100%; object-fit:contain; border-radius:6px; box-shadow:0 4px 40px rgba(0,0,0,0.7); cursor:default; user-select:none; display:none;"
             onclick="event.stopPropagation()">
        <iframe id="gallery-lb-frame"
                src=""
                title="{{ __('Media') }}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; xr-spatial-tracking; fullscreen"
                allowfullscreen
                style="width:100%; height:100%; border:0; border-radius:6px; background:#000; box-shadow:0 4px 40px rgba(0,0,0,0.7); display:none;"
                onclick="event.stopPropagation()"></iframe>
        <video id="gallery-lb-video"
               src=""
               controls playsinline
               style="max-width:100%; max-height:100%; border-radius:6px; background:#000; box-shadow:0 4px 40px rgba(0,0,0,0.7); display:none;"
               onclick="event.stopPropagation()"></video>
    </div>
    <button onclick="glbClose(null)"
            style="position:fixed; top:16px; right:20px; background:rgba(255,255,255,0.15); border:none; color:#fff; font-size:2rem; width:46px; height:46px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:10001; transition:background 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.3)'"
            onmouseout="this.style.background='rgba(255,255,255,0.15)'"
            title="{{ __('Close') }}">&times;</button>
    <a id="gallery-lb-open"
       href="#" target="_blank" rel="noopener noreferrer"
       onclick="event.stopPropagation()"
       style="position:fixed; top:20px; right:78px; background:rgba(255,255,255,0.15); color:#fff; text-decoration:none; font-size:13px; padding:9px 14px; border-radius:22px; z-index:10001; display:none; align-items:center; gap:6px; transition:background 0.2s;"
       onmouseover="this.style.background='rgba(255,255,255,0.3)'"
       onmouseout="this.style.background='rgba(255,255,255,0.15)'">
        <i class="fas fa-external-link-alt"></i> {{ __('Open in new tab') }}
    </a>
    <button id="gallery-lb-prev"
            onclick="glbNav(-1)"
            style="position:fixed; left:14px; top:50%; transform:translateY(-50%); background:rgba(255,255,255,0.15); border:none; color:#fff; font-size:2rem; width:46px; height:46px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:10001; transition:background 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.3)'"
            onmouseout="this.style.background='rgba(255,255,255,0.15)'"
            title="{{ __('Previous') }}">&#8249;</button>
    <button id="gallery-lb-next"
            onclick="glbNav(1)"
            style="position:fixed; right:14px; top:50%; transform:translateY(-50%); background:rgba(255,255,255,0.15); border:none; color:#fff; font-size:2rem; width:46px; height:46px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:10001; transition:background 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.3)'"
            onmouseout="this.style.background='rgba(255,255,255,0.15)'"
            title="{{ __('Next') }}">&#8250;</button>
    <div id="gallery-lb-caption"
         style="position:fixed; bottom:40px; left:50%; transform:translateX(-50%); max-width:80vw; text-align:center; color:#fff; font-size:14px; z-index:10001; pointer-events:none; text-shadow:0 1px 6px rgba(0,0,0,.8);"></div>
    <div id="gallery-lb-counter"
         style="position:fixed; bottom:18px; left:50%; transform:translateX(-50%); color:rgba(255,255,255,0.7); font-size:13px; z-index:10001; pointer-events:none;"></div>
</div>

<style>
.gallery-tab-scroll-wrap {
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    background: #fafafa;
    border-bottom: 2px solid var(--primary-color, #ff6600);
    margin-bottom: 1.5rem;
    padding: 10px 12px 0;
}
/* Desktop: show a thin scrollbar with spacing below */
.gallery-tab-scroll-wrap::-webkit-scrollbar { height: 5px; }
.gallery-tab-scroll-wrap::-webkit-scrollbar-track { background: transparent; margin: 0 8px; }
.gallery-tab-scroll-wrap::-webkit-scrollbar-thumb { background: #bbb; border-radius: 3px; }
.gallery-tab-scroll-wrap { scrollbar-width: thin; scrollbar-color: #bbb transparent; }
/* Mobile: hide scrollbar */
@media (max-width: 991.98px) {
    .gallery-tab-scroll-wrap { padding: 8px 8px 0; }
    .gallery-tab-scroll-wrap::-webkit-scrollbar { display: none; }
    .gallery-tab-scroll-wrap { -ms-overflow-style: none; scrollbar-width: none; }
}
.gallery-nav-tabs {
    flex-wrap: nowrap;
    border-bottom: none;
    gap: 6px;
    width: 100%;
    list-style: none;
    margin: 0;
    padding: 0 0 0 0;
    padding-bottom: 0;
}
.gallery-nav-tabs .nav-item {
    flex: 1 0 calc((100% - 30px) / 6);
    list-style: none !important;
}
.gallery-nav-tabs .nav-item::before,
.gallery-nav-tabs .nav-item::after,
.gallery-nav-tabs .nav-item::marker {
    display: none !important;
    content: '' !important;
}
.gallery-nav-tabs .nav-link {
    color: #555;
    font-weight: 600;
    font-size: 14px;
    padding: 8px 10px;
    border: 1px solid #ddd;
    border-bottom: none;
    border-radius: 4px 4px 0 0;
    background: #f8f8f8;
    transition: all 0.2s;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: center;
    width: 100%;
    display: block;
    box-sizing: border-box;
}
.gallery-nav-tabs .nav-link:hover {
    color: var(--primary-color, #ff6600);
    background: #fff;
    border-color: var(--primary-color, #ff6600);
}
.gallery-nav-tabs .nav-link.active {
    color: #fff;
    background: var(--primary-color, #ff6600);
    border-color: var(--primary-color, #ff6600);
}
@media (max-width: 575.98px) {
    .gallery-nav-tabs .nav-link {
        font-size: 13px;
        padding: 7px 14px;
    }
}
.wrapImgResize {
    position: relative;
    overflow: hidden;
    background: #e8e8e8;
    border-radius: 4px;
}
.img3And2 {
    padding-bottom: 66.67%;
}
.wrapImgResize img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.35s ease;
}
.colItem:hover .wrapImgResize img {
    transform: scale(1.06);
}
.colItem:hover .wrapImgResize::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.18);
    pointer-events: none;
}
/* Ô video / VR360: nền tối để icon luôn đọc được kể cả khi chưa có ảnh đại diện */
.gallery-tile--video,
.gallery-tile--vr360 {
    background: #14141f;
}
.gallery-tile--video img,
.gallery-tile--vr360 img {
    opacity: .82;
}
.gallery-tile-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: rgba(0,0,0,.45);
    border: 2px solid rgba(255,255,255,.85);
    color: #fff;
    font-size: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
    pointer-events: none;
    transition: transform .25s ease, background .25s ease;
}
.gallery-tile-icon--vr {
    color: #00d4ff;
    border-color: rgba(0, 212, 255, .85);
}
.colItem:hover .gallery-tile-icon {
    transform: translate(-50%, -50%) scale(1.12);
    background: rgba(0,0,0,.65);
}
.gallery-tile-badge {
    position: absolute;
    left: 8px;
    bottom: 8px;
    z-index: 2;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .5px;
    color: #fff;
    pointer-events: none;
}
.gallery-tile-badge--video { background: rgba(13, 110, 253, .9); }
.gallery-tile-badge--vr { background: rgba(0, 150, 180, .92); }
</style>

<script>
(function () {
    var lb       = document.getElementById('gallery-lightbox');
    var lbStage  = document.getElementById('gallery-lb-stage');
    var lbImg    = document.getElementById('gallery-lb-img');
    var lbFrame  = document.getElementById('gallery-lb-frame');
    var lbVideo  = document.getElementById('gallery-lb-video');
    var lbOpen   = document.getElementById('gallery-lb-open');
    var lbCap    = document.getElementById('gallery-lb-caption');
    var lbCnt    = document.getElementById('gallery-lb-counter');
    var curItems = [];
    var curIdx   = 0;

    function readItem(el) {
        return {
            type: el.getAttribute('data-lb-type') || 'image',
            kind: el.getAttribute('data-lb-kind') || 'image',
            src:  el.getAttribute('data-lb-src') || '',
            link: el.getAttribute('data-lb-link') || '',
            desc: el.getAttribute('data-lb-desc') || ''
        };
    }

    function attachItems() {
        document.querySelectorAll('.colItem[data-lb-src]').forEach(function (item) {
            item.addEventListener('click', function () {
                var gid = this.getAttribute('data-gallery-id');
                var idx = parseInt(this.getAttribute('data-idx'), 10) || 0;
                curItems = [];
                document.querySelectorAll('.colItem[data-gallery-id="' + gid + '"]').forEach(function (el) {
                    curItems.push(readItem(el));
                });
                curIdx = idx;
                openLb();
            });
        });
    }

    // Ẩn hết media rồi mới bật đúng loại của item hiện tại
    function resetMedia() {
        lbImg.style.display = 'none';
        lbImg.src = '';
        lbFrame.style.display = 'none';
        lbFrame.src = '';
        lbVideo.style.display = 'none';
        lbVideo.pause();
        lbVideo.removeAttribute('src');
        lbVideo.load();
    }

    function render() {
        var item = curItems[curIdx];
        if (!item) return;

        resetMedia();

        if (item.type === 'iframe') {
            lbFrame.src = item.src;
            lbFrame.style.display = 'block';
        } else if (item.type === 'video') {
            lbVideo.src = item.src;
            lbVideo.style.display = 'block';
            lbVideo.load();
            var playing = lbVideo.play();
            if (playing && playing.catch) { playing.catch(function () {}); }
        } else {
            lbImg.src = item.src;
            lbImg.style.display = 'block';
        }

        // Nút mở tab mới: cần cho VR360 / video khi trang nguồn chặn nhúng iframe
        if (item.kind !== 'image' && item.link) {
            lbOpen.href = item.link;
            lbOpen.style.display = 'flex';
        } else {
            lbOpen.style.display = 'none';
        }

        lbCap.textContent = item.desc || '';
        lbCnt.textContent = (curIdx + 1) + ' / ' + curItems.length;
    }

    function openLb() {
        if (!curItems.length) return;
        lb.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        render();
    }

    window.glbClose = function (e) {
        if (e && e.target !== lb && e.target !== lbStage) return;
        lb.style.display = 'none';
        document.body.style.overflow = '';
        resetMedia();
        lbCap.textContent = '';
    };

    window.glbNav = function (dir) {
        if (!curItems.length) return;
        curIdx = (curIdx + dir + curItems.length) % curItems.length;
        render();
    };

    document.addEventListener('keydown', function (e) {
        if (lb.style.display !== 'flex') return;
        if (e.key === 'Escape')      { glbClose(null); }
        if (e.key === 'ArrowLeft')   { glbNav(-1); }
        if (e.key === 'ArrowRight')  { glbNav(1); }
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', attachItems);
    } else {
        attachItems();
    }
})();
</script>

@endif
