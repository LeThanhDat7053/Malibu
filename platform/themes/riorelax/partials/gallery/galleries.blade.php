@if (isset($galleries) && !$galleries->isEmpty())

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
            $images = function_exists('gallery_meta_data') ? gallery_meta_data($gallery) : [];
            $images = array_values(array_filter($images, fn($img) => !empty(\Illuminate\Support\Arr::get($img, 'img'))));
        @endphp
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
             id="gtab-pane-{{ $gallery->id }}"
             role="tabpanel"
             aria-labelledby="gtab-btn-{{ $gallery->id }}">
            <div class="row listGalleryItem">
                @forelse ($images as $idx => $image)
                    @php
                        $imgPath = \Illuminate\Support\Arr::get($image, 'img');
                        $fullUrl  = RvMedia::getImageUrl($imgPath);
                        $thumbUrl = RvMedia::getImageUrl($imgPath, 'medium');
                        $desc     = BaseHelper::clean(\Illuminate\Support\Arr::get($image, 'description', ''));
                    @endphp
                    <div class="col-6 col-md-4 col-lg-3 colItem mb-3"
                         data-full="{{ $fullUrl }}"
                         data-gallery-id="{{ $gallery->id }}"
                         data-idx="{{ $idx }}"
                         title="{{ $desc }}"
                         style="cursor:pointer;">
                        <div class="wrapImgResize img3And2">
                            <img src="{{ $thumbUrl }}"
                                 alt="{{ $desc }}"
                                 loading="lazy">
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
    <img id="gallery-lb-img"
         src="" alt=""
         style="max-width:90%; max-height:85vh; border-radius:6px; box-shadow:0 4px 40px rgba(0,0,0,0.7); cursor:default; user-select:none; display:block;"
         onclick="event.stopPropagation()">
    <button onclick="glbClose(null)"
            style="position:fixed; top:16px; right:20px; background:rgba(255,255,255,0.15); border:none; color:#fff; font-size:2rem; width:46px; height:46px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:10001; transition:background 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.3)'"
            onmouseout="this.style.background='rgba(255,255,255,0.15)'"
            title="{{ __('Close') }}">&times;</button>
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
</style>

<script>
(function () {
    var lb       = document.getElementById('gallery-lightbox');
    var lbImg    = document.getElementById('gallery-lb-img');
    var lbCnt    = document.getElementById('gallery-lb-counter');
    var curItems = [];
    var curIdx   = 0;

    function attachItems() {
        document.querySelectorAll('.colItem[data-full]').forEach(function (item) {
            item.addEventListener('click', function () {
                var gid = this.getAttribute('data-gallery-id');
                var idx = parseInt(this.getAttribute('data-idx'), 10);
                curItems = [];
                document.querySelectorAll('.colItem[data-gallery-id="' + gid + '"]').forEach(function (el) {
                    curItems.push(el.getAttribute('data-full'));
                });
                curIdx = idx;
                openLb();
            });
        });
    }

    function openLb() {
        if (!curItems.length) return;
        lbImg.src = curItems[curIdx];
        lb.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        updateCnt();
    }

    window.glbClose = function (e) {
        if (e && e.target !== lb) return;
        lb.style.display = 'none';
        document.body.style.overflow = '';
        lbImg.src = '';
    };

    window.glbNav = function (dir) {
        curIdx = (curIdx + dir + curItems.length) % curItems.length;
        lbImg.src = curItems[curIdx];
        updateCnt();
    };

    function updateCnt() {
        if (lbCnt) lbCnt.textContent = (curIdx + 1) + ' / ' + curItems.length;
    }

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
