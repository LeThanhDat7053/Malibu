@php
    Theme::set('pageTitle', trans('plugins/restaurant::restaurant.name'));
@endphp

<section class="rst-listing">
    <div class="container">
        @if ($restaurants->isEmpty())
            <p class="text-center py-5 text-muted">
                {{ trans('plugins/restaurant::restaurant.no_restaurants') }}
            </p>
        @else
            <div class="rst-listing__grid">
                @foreach ($restaurants as $restaurant)
                    {!! Theme::partial('restaurants.item', compact('restaurant')) !!}
                @endforeach
            </div>
        @endif
    </div>
</section>
