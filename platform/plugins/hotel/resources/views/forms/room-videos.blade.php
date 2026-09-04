{{-- Room Videos admin section: Add Video URL (from link or local upload) --}}
<input type="hidden" id="room-videos-data" name="room_videos_data" value="{{ json_encode($videos ?? []) }}">

<div class="room-videos-wrapper">
    {{-- Video items list --}}
    <div class="list-photos-gallery">
        <div class="row" id="room-videos-items">
            @if (!empty($videos))
                @foreach ($videos as $key => $item)
                    @php
                        $videoUrl = $item['img'] ?? '';
                        $thumbUrl = $item['thumb'] ?? null;
                        $description = $item['description'] ?? '';
                        $ytId = null;
                        if ($videoUrl && preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $videoUrl, $ytMatch)) {
                            $ytId = $ytMatch[1];
                        }
                    @endphp
                    <div
                        class="col-md-2 col-sm-3 col-4 room-video-item"
                        data-id="{{ $key }}"
                        data-img="{{ $videoUrl }}"
                        data-description="{{ $description }}"
                        data-thumb="{{ $thumbUrl }}"
                    >
                        <div class="gallery_image_wrapper position-relative">
                            @if ($ytId)
                                <img src="https://img.youtube.com/vi/{{ $ytId }}/hqdefault.jpg" alt="video" loading="lazy" style="width:100%;aspect-ratio:1;object-fit:cover;border-radius:4px;">
                            @elseif ($thumbUrl)
                                <img src="{{ $thumbUrl }}" alt="video" loading="lazy" style="width:100%;aspect-ratio:1;object-fit:cover;border-radius:4px;">
                            @else
                                <div class="room-video-placeholder" style="width:100%;aspect-ratio:1;background:#1a1a2e;display:flex;align-items:center;justify-content:center;border-radius:4px;">
                                    <i class="fas fa-video" style="font-size:28px;color:#0d6efd;"></i>
                                </div>
                            @endif
                            <span class="position-absolute top-0 start-0 badge bg-primary" style="font-size:9px;z-index:2;">VIDEO</span>
                            {{-- Overlay with Edit + Remove buttons --}}
                            <div class="room-video-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center gap-1">
                                <button type="button" class="btn-edit-room-video btn btn-sm btn-light px-2 py-1" style="font-size:11px;">
                                    <i class="fas fa-edit me-1"></i>{{ __('Edit') }}
                                </button>
                                <button type="button" class="btn-remove-room-video btn btn-sm btn-danger px-2 py-1" style="font-size:11px;">
                                    <i class="fas fa-trash me-1"></i>{{ __('Remove') }}
                                </button>
                            </div>
                        </div>
                        <div class="mt-1" style="font-size:10px;color:#666;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:100%;" title="{{ $videoUrl }}">
                            {{ \Illuminate\Support\Str::limit($videoUrl, 30) }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- Action button --}}
    <div class="d-flex gap-2 flex-wrap align-items-center mt-2">
        <button type="button"
                id="room-video-open-modal-btn"
                class="btn-link border-0 bg-transparent p-0"
                style="cursor:pointer;">
            <i class="fas fa-video me-1"></i> {{ __('Add Video URL') }}
        </button>
    </div>
</div>

{{-- Add/Edit Video Modal --}}
<div class="modal fade" id="room-add-video-modal" tabindex="-1" aria-labelledby="room-add-video-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="room-add-video-modal-label">{{ __('Add Video URL') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('core/base::forms.cancel') }}"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('URL') }}</label>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control" id="room-video-url-input"
                               placeholder="https://www.youtube.com/watch?v=... or direct .mp4 link">
                        <button type="button" class="btn btn-sm btn-outline-secondary flex-shrink-0" id="room-video-browse-btn" title="{{ __('Select from Media Library') }}">
                            <i class="fas fa-photo-video"></i>
                        </button>
                    </div>
                    <small class="form-text text-muted">{{ __('Supported: YouTube, Vimeo, direct .mp4 URL, or select from media library') }}</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('Thumbnail image (optional)') }}</label>
                    <div class="d-flex gap-2 align-items-center">
                        <input type="text" class="form-control" id="room-video-thumb-input"
                               placeholder="{{ __('Select or paste image URL') }}" readonly>
                        <button type="button" class="btn btn-secondary btn-sm flex-shrink-0" id="room-video-thumb-browse-btn">{{ __('Select') }}</button>
                        <button type="button" class="btn btn-outline-danger btn-sm flex-shrink-0" id="room-video-thumb-clear-btn" style="display:none;">&#x2715;</button>
                    </div>
                    <div id="room-video-thumb-preview" style="display:none;margin-top:8px;">
                        <img src="" alt="thumbnail" style="max-height:80px;border-radius:4px;border:1px solid #ddd;">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('Description (optional)') }}</label>
                    <input type="text" class="form-control" id="room-video-description-input" placeholder="{{ __('Description') }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('core/base::forms.cancel') }}</button>
                <button type="button" class="btn btn-primary" id="room-video-confirm-btn">{{ __('Add') }}</button>
            </div>
        </div>
    </div>
</div>

<style>
.room-video-overlay {
    background: rgba(0,0,0,.55);
    opacity: 0;
    transition: opacity .2s;
    border-radius: 4px;
    z-index: 3;
    pointer-events: none;  /* invisible overlay must NOT capture clicks */
}
.room-video-item:hover .room-video-overlay {
    opacity: 1 !important;
    pointer-events: auto;  /* only capture clicks when visible */
}
</style>