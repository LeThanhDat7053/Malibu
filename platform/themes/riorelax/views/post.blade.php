@php
    Theme::set('pageTitle', $post->name);
    Theme::set('breadcrumbPageKey', 'blog');
    $recentPosts = get_recent_posts(5);
@endphp

@once
<style>
    .blog-details-wrap,
    .blog-details-wrap .details__content,
    .blog-details-wrap .ck-content {
        min-width: 0;
    }

    .blog-details-wrap .ck-content {
        max-width: 100%;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    .blog-details-wrap .ck-content > * {
        max-width: 100%;
    }

    .blog-details-wrap .ck-content img,
    .blog-details-wrap .ck-content video,
    .blog-details-wrap .ck-content canvas,
    .blog-details-wrap .ck-content svg,
    .blog-details-wrap .ck-content iframe,
    .blog-details-wrap .ck-content embed,
    .blog-details-wrap .ck-content object {
        max-width: 100% !important;
        height: auto !important;
    }

    .blog-details-wrap .ck-content figure,
    .blog-details-wrap .ck-content .image,
    .blog-details-wrap .ck-content .table-responsive,
    .blog-details-wrap .ck-content .wp-block-image,
    .blog-details-wrap .ck-content .wp-block-embed {
        max-width: 100%;
    }

    .blog-details-wrap .ck-content figure {
        width: 100%;
        margin: 24px 0;
    }

    .blog-details-wrap .ck-content figure img {
        float: none;
        margin: 0;
    }

    .blog-details-wrap .ck-content table {
        display: block;
        width: 100% !important;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .blog-details-wrap .ck-content pre,
    .blog-details-wrap .ck-content code {
        white-space: pre-wrap;
        word-break: break-word;
    }

    .blog-details-wrap .ck-content iframe {
        width: 100%;
    }

    /* H1 inside blog content - green left border style */
    .ck-content h1 {
        font-size: 22px;
        font-weight: 700;
        color: var(--primary-color);
        border-left: 4px solid var(--primary-color);
        padding: 8px 0 8px 15px;
        margin: 30px 0 15px;
        line-height: 1.4;
    }

    /* Sidebar: "Có thể bạn quan tâm" */
    .blog-detail-related {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
    }

    .blog-detail-related-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary-color);
        text-transform: uppercase;
    }

    .blog-detail-related-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 10px 0;
        border-bottom: 1px solid #e8e8e8;
    }

    .blog-detail-related-item:last-child {
        border-bottom: none;
    }

    .blog-detail-related-thumb {
        flex: 0 0 80px;
        height: 55px;
        overflow: hidden;
        border-radius: 4px;
    }

    .blog-detail-related-thumb a {
        display: block;
        height: 100%;
    }

    .blog-detail-related-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .blog-detail-related-item:hover .blog-detail-related-thumb img {
        transform: scale(1.05);
    }

    .blog-detail-related-info {
        flex: 1;
        min-width: 0;
    }

    .blog-detail-related-info .related-date {
        font-size: 11px;
        color: #999;
        display: block;
        margin-bottom: 3px;
    }

    .blog-detail-related-info h5 {
        font-size: 13px;
        font-weight: 600;
        margin: 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .blog-detail-related-info h5 a {
        color: #333;
        text-decoration: none;
    }

    .blog-detail-related-info h5 a:hover {
        color: var(--primary-color);
    }
</style>
@endonce

<section class="inner-blog b-details-p pt-80 pb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-details-wrap">
                    <div class="details__content pb-30">
                        <h2>{{ $post->name }}</h2>
                        <div class="meta-info">
                            <ul>
                                <li><i class="fal fa-eye"></i>{{ number_format($post->views) }}</li>
                                <li><i class="fal fa-calendar-alt"></i>{{ Theme::formatDate($post->created_at) }}</li>
                            </ul>
                        </div>
                        <div class="ck-content">
                            {!! $post->content !!}
                        </div>
                        @if (function_exists('gallery_meta_data'))
                            @php($galleryItems = gallery_meta_data($post))
                            @if (!empty($galleryItems))
                                {!! Theme::partial('media-gallery', ['items' => $galleryItems, 'id' => 'post-gallery']) !!}
                            @endif
                        @endif
                        @if ($post->tags->isNotEmpty())
                            <div class="row">
                                <div class="col-xl-12 col-md-12">
                                    <div class="post__tag">
                                        <h5>{{ __('Related Tags') }}</h5>
                                        <ul>
                                            @foreach($post->tags as $tag)
                                                <li>
                                                    <a href="{{ $tag->url }}">{{ $tag->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mb-60"></div>

                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-4">
                <aside class="sidebar-widget">
                    <div class="blog-detail-related">
                        <div class="blog-detail-related-title">{{ __('You may be interested') }}</div>
                        @foreach($recentPosts as $recentPost)
                            <div class="blog-detail-related-item">
                                <div class="blog-detail-related-thumb">
                                    <a href="{{ $recentPost->url }}">
                                        @if($recentPost->image)
                                            <img src="{{ RvMedia::getImageUrl($recentPost->image, 'small') }}" alt="{{ $recentPost->name }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="blog-detail-related-info">
                                    <span class="related-date">{{ Theme::formatDate($recentPost->created_at) }}</span>
                                    <h5><a href="{{ $recentPost->url }}">{{ $recentPost->name }}</a></h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
