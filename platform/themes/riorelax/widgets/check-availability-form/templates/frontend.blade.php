{{-- Cùng khung với hộp đặt phòng ở trang chi tiết phòng --}}
<div class="mlb-rd-widget mlb-rd-widget--booking">
    @if ($title = $config['title'])
        <h2 class="mlb-rd-widget__title">{!! BaseHelper::clean($title) !!}</h2>
    @endif

    {!! Theme::partial('hotel.forms.form', ['style' => 1, 'availableForBooking' => false]) !!}
</div>
