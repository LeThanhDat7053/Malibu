<div class="product-card shadow-block h-100">
    <div class="product-card-image position-relative hover-zoomin" style="aspect-ratio: 4/3; overflow: hidden;">
        <a href="{{ $product->url }}">
            <img src="{{ $product->image ? RvMedia::getImageUrl($product->image, 'medium') : Theme::asset()->url('images/placeholder.svg') }}"
                 alt="{{ $product->name }}"
                 class="w-100 product-card-img"
                 style="width: 100%; height: 100%; object-fit: cover;"
                 onerror="this.onerror=null;this.src='{{ Theme::asset()->url('images/placeholder.svg') }}';">
        </a>
        @if ($product->sale_end_date && $product->isWithinSalePeriod())
            <span class="badge bg-warning text-dark position-absolute" style="top: 10px; left: 10px; font-size: 0.7em;">
                <i class="fal fa-clock"></i> {{ $product->sale_end_date->format('d/m/Y') }}
            </span>
        @endif
    </div>
    <div class="product-card-body p-3">
        @if ($product->category)
            <small class="text-muted product-category-name mb-1">{{ $product->category->name }}</small>
        @else
            <small class="text-muted product-category-name mb-1">&nbsp;</small>
        @endif
        <h5 class="mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: 2.8em; line-height: 1.4em;">
            <a href="{{ $product->url }}">{{ $product->name }}</a>
        </h5>
        <div class="product-price mt-2">
            @if ($product->original_price && $product->original_price > $product->price)
                <strong class="text-primary product-price-text">
                    {{ number_format($product->price, 0, ',', '.') }} ~ {{ number_format($product->original_price, 0, ',', '.') }} <small>VND</small>
                </strong>
            @else
                <strong class="text-primary product-price-text">
                    {{ number_format($product->price, 0, ',', '.') }} <small>VND</small>
                </strong>
            @endif
        </div>
        <small class="text-muted">{{ __('Sold') }}: {{ number_format($product->total_sold) }}</small>
        <div class="mt-3">
            @if ($product->isWithinSalePeriod())
                <a href="{{ $product->url }}" class="btn ss-btn btn-sm w-100">{{ __('Order Now') }}</a>
            @else
                <span class="btn btn-secondary btn-sm w-100 disabled">{{ __('Ended') }}</span>
            @endif
        </div>
    </div>
</div>
