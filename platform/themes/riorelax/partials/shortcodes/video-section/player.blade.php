{{-- Trình phát: file mp4 chạy thẳng, YouTube ở bố cục chia đôi chỉ nạp iframe khi bấm --}}
@php
    $background = $background ?? false;
@endphp

@if ($videoFile)
    <video
        class="mlb-video__el"
        @if ($poster) poster="{{ $poster }}" @endif
        @if ($background) autoplay muted loop playsinline preload="metadata" @else controls preload="none" @endif
    >
        <source src="{{ $videoFile }}" type="video/mp4">
    </video>
@elseif ($youtubeId && $background)
    <div class="mlb-video__frame">
        <iframe
            src="https://www.youtube-nocookie.com/embed/{{ $youtubeId }}?autoplay=1&mute=1&loop=1&playlist={{ $youtubeId }}&controls=0&modestbranding=1&rel=0&playsinline=1&disablekb=1"
            title="{{ __('Video') }}"
            frameborder="0"
            allow="autoplay; encrypted-media"
            allowfullscreen
            tabindex="-1"
        ></iframe>
    </div>
@elseif ($youtubeId)
    <button
        type="button"
        class="mlb-video__facade"
        data-mlb-video-embed="https://www.youtube-nocookie.com/embed/{{ $youtubeId }}?autoplay=1&rel=0&modestbranding=1"
        aria-label="{{ __('Play video') }}"
    >
        <img src="{{ $poster ?: 'https://i.ytimg.com/vi/' . $youtubeId . '/maxresdefault.jpg' }}" alt="" loading="lazy">
        <span class="mlb-video__play" aria-hidden="true"></span>
    </button>
@elseif ($poster)
    <img class="mlb-video__el" src="{{ $poster }}" alt="" loading="lazy">
@endif
