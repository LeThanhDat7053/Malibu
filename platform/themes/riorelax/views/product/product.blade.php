@php
    Theme::set('pageTitle', $product->name);
    Theme::set('breadcrumbPageKey', 'product');
@endphp

<section class="pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-6">
                <div class="product-detail-image mb-30">
                    <img id="main-product-image" src="{{ RvMedia::getImageUrl($product->image) }}" alt="{{ $product->name }}" class="rounded" style="max-width: 70%; height: auto; display: block; cursor: zoom-in;" onclick="openProductLightbox(this.src, this.alt)" title="{{ __('Click to view full image') }}">
                </div>
                @if ($product->images && count($product->images) > 0)
                    <div class="row g-2 mt-3 mb-30">
                        <div class="col-3">
                            <img src="{{ RvMedia::getImageUrl($product->image, 'thumb') }}"
                                 data-full="{{ RvMedia::getImageUrl($product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-100 rounded product-thumb"
                                 style="height: 120px; object-fit: cover; cursor: pointer; border: 2px solid #ff6600; transition: border-color 0.2s;"
                                 onclick="document.getElementById('main-product-image').src=this.dataset.full; document.querySelectorAll('.product-thumb').forEach(function(t){t.style.borderColor='transparent'}); this.style.borderColor='#ff6600';">
                        </div>
                        @foreach ($product->images as $img)
                            <div class="col-3">
                                <img src="{{ RvMedia::getImageUrl($img, 'thumb') }}"
                                     data-full="{{ RvMedia::getImageUrl($img) }}"
                                     alt="{{ $product->name }}"
                                     class="w-100 rounded product-thumb"
                                     style="height: 120px; object-fit: cover; cursor: pointer; border: 2px solid transparent; transition: border-color 0.2s;"
                                     onclick="document.getElementById('main-product-image').src=this.dataset.full; document.querySelectorAll('.product-thumb').forEach(function(t){t.style.borderColor='transparent'}); this.style.borderColor='#ff6600';">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-lg-5 col-md-6">
                <div class="product-detail-info">
                    <h2>{{ $product->name }}</h2>
                    @if ($product->category)
                        <span class="badge bg-secondary mb-3">{{ $product->category->name }}</span>
                    @endif

                    <div class="product-price mb-3">
                        <strong class="text-primary" style="font-size: 1.5em;">
                            {{ number_format($product->price, 0, ',', '.') }}
                            @if ($product->original_price && $product->original_price > $product->price)
                                ~ {{ number_format($product->original_price, 0, ',', '.') }}
                            @endif
                            VND
                        </strong>
                    </div>

                    @if ($product->total_sold > 0)
                        <p class="text-muted mb-3"><i class="fal fa-check-circle"></i> {{ __('Sold') }}: {{ number_format($product->total_sold) }}</p>
                    @endif

                    {{-- Sale period info --}}
                    @if ($product->sale_start_date || $product->sale_end_date)
                        <div class="sale-period-info mb-3 p-2 rounded" style="background: #fff8e1; border: 1px solid #ffe082;">
                            <i class="fal fa-clock text-warning"></i>
                            <strong>{{ __('Promotion Period') }}:</strong>
                            @if ($product->sale_start_date && $product->sale_end_date)
                                {{ $product->sale_start_date->format('d/m/Y') }} — {{ $product->sale_end_date->format('d/m/Y') }}
                            @elseif ($product->sale_end_date)
                                {{ __('Available until :date', ['date' => $product->sale_end_date->format('d/m/Y')]) }}
                            @elseif ($product->sale_start_date)
                                {{ __('Available from :date', ['date' => $product->sale_start_date->format('d/m/Y')]) }}
                            @endif
                            @if (! $product->isWithinSalePeriod())
                                <br><span class="text-danger fw-bold">{{ __('This promotion has ended') }}</span>
                            @endif
                        </div>
                    @endif

                    @if ($product->description)
                        <div class="mb-4">
                            <p>{{ $product->description }}</p>
                        </div>
                    @endif

                    @if ($product->isWithinSalePeriod())
                    <div class="order-form-wrapper shadow-block p-4 rounded">
                        <h4 class="mb-3">{{ __('Order Now') }}</h4>
                        <form action="{{ route('public.product.order') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="mb-3">
                                <label class="form-label">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="fal fa-user"></i>
                                    <input type="text" name="customer_name" class="form-control form-control-icon" required value="{{ old('customer_name') }}" maxlength="120" placeholder="{{ __('Full Name') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="fal fa-envelope"></i>
                                    <input type="email" name="customer_email" class="form-control form-control-icon" required value="{{ old('customer_email') }}" maxlength="120" placeholder="{{ __('Email') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('Phone') }} <span class="text-danger">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="fal fa-phone"></i>
                                    <input type="tel" name="customer_phone" class="form-control form-control-icon" required value="{{ old('customer_phone') }}" placeholder="{{ __('Phone') }}">
                                </div>
                            </div>

                            @if ($product->enable_booking)
                                <div class="booking-schedule-box mb-3">
                                    <div class="booking-schedule-header">
                                        <i class="fal fa-calendar-check"></i> {{ __('Choose Date & Time') }}
                                    </div>
                                    <div class="booking-schedule-body">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <label class="form-label fw-semibold"><i class="fal fa-calendar-alt me-1"></i>{{ __('Service Date') }} <span class="text-danger">*</span></label>
                                                @php
                                                    $dateMin = ($product->sale_start_date && $product->sale_start_date->isFuture()) ? $product->sale_start_date->format('Y-m-d') : \Carbon\Carbon::today()->format('Y-m-d');
                                                    $dateMax = $product->sale_end_date ? $product->sale_end_date->format('Y-m-d') : null;
                                                @endphp
                                                <input type="date" name="service_date" id="service-date" class="form-control" required value="{{ old('service_date') }}" min="{{ $dateMin }}"{{ $dateMax ? ' max="'.$dateMax.'"' : '' }}>
                                                <small class="booking-hint" id="available-days-hint"></small>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label fw-semibold"><i class="fal fa-clock me-1"></i>{{ __('Service Time') }} <span class="text-danger">*</span></label>
                                                <select name="service_time" id="service-time" class="form-control" required>
                                                    <option value="">{{ __('-- Select date first --') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label">{{ __('Quantity') }}</label>
                                    <input type="number" name="quantity" class="form-control" value="1" min="1" max="100">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('Note') }}</label>
                                <textarea name="customer_note" class="form-control" rows="3" maxlength="1000" placeholder="{{ __('Note') }}">{{ old('customer_note') }}</textarea>
                            </div>

                            <button type="submit" class="btn ss-btn w-100">
                                <i class="fal fa-shopping-cart"></i> {{ __('Place Order') }}
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="order-form-wrapper shadow-block p-4 rounded text-center">
                        <p class="text-danger fw-bold mb-0"><i class="fal fa-exclamation-circle"></i> {{ __('This promotion has ended') }}</p>
                    </div>
                    @endif

                    <style>
                        .order-form-wrapper { background: #fff; border: 1px solid #eee; }
                        .order-form-wrapper h4 { font-weight: 700; color: #333; border-bottom: 2px solid var(--primary-color); padding-bottom: 10px; }
                        .input-icon-wrap { position: relative; }
                        .input-icon-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #999; font-size: 15px; z-index: 1; }
                        .form-control-icon { padding-left: 40px !important; }
                        .booking-schedule-box { border: 2px solid var(--primary-color); border-radius: 10px; overflow: hidden; }
                        .booking-schedule-header { background: var(--primary-color); color: #fff; padding: 10px 16px; font-weight: 600; font-size: 15px; }
                        .booking-schedule-header i { margin-right: 6px; }
                        .booking-schedule-body { padding: 16px; background: #fafafa; }
                        .booking-schedule-body .form-control { border: 1px solid #ddd; border-radius: 6px; height: 44px; font-size: 14px; }
                        .booking-schedule-body .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(0,0,0,0.08); }
                        .booking-hint { display: block; margin-top: 6px; color: var(--primary-color); font-size: 12px; font-weight: 500; }
                        .booking-schedule-body select.is-invalid { border-color: #dc3545; background-color: #fff5f5; }
                        .order-form-wrapper .form-control { border-radius: 6px; height: 44px; border: 1px solid #ddd; transition: border-color 0.2s; }
                        .order-form-wrapper .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(0,0,0,0.06); }
                        .order-form-wrapper textarea.form-control { height: auto; }
                        .order-form-wrapper .form-label { font-size: 13px; font-weight: 600; color: #555; margin-bottom: 5px; }
                    </style>

                    @if ($product->enable_booking)
                    @php
                        $dayNamesArray = [
                            __('Sunday'), __('Monday'), __('Tuesday'), __('Wednesday'),
                            __('Thursday'), __('Friday'), __('Saturday')
                        ];
                    @endphp
                    <script>
                    (function() {
                        var serviceDays = @json($product->service_days ?? []).map(Number);
                        var startTime = @json($product->service_start_time ?? '08:00').substring(0, 5);
                        var endTime = @json($product->service_end_time ?? '22:00').substring(0, 5);
                        var slotDuration = {{ $product->time_slot_duration ?? 60 }};
                        var selectTimeLabel = @json(__('-- Select time --'));
                        var selectDateFirstLabel = @json(__('-- Select date first --'));
                        var dayNotAvailableLabel = @json(__('This day is not available for service'));
                        var saleEndDate = @json($product->sale_end_date ? $product->sale_end_date->format('Y-m-d') : null);
                        var saleStartDate = @json($product->sale_start_date ? $product->sale_start_date->format('Y-m-d') : null);
                        var dateOutOfRangeLabel = @json(trans('plugins/product::product.validation.date_out_of_sale_period'));

                        var dayNames = @json($dayNamesArray);

                        // Show available days hint
                        var hintEl = document.getElementById('available-days-hint');
                        if (serviceDays.length > 0 && serviceDays.length < 7) {
                            var availableDayNames = serviceDays.map(function(d) { return dayNames[d]; });
                            hintEl.textContent = '{{ __("Available") }}: ' + availableDayNames.join(', ');
                        }

                        var dateInput = document.getElementById('service-date');
                        var timeSelect = document.getElementById('service-time');

                        function generateTimeSlots() {
                            var start = parseTime(startTime);
                            var end = parseTime(endTime);
                            var slots = [];
                            var current = start;
                            while (current < end) {
                                slots.push(formatTime(current));
                                current += slotDuration;
                            }
                            return slots;
                        }

                        function parseTime(str) {
                            var parts = str.split(':');
                            return parseInt(parts[0]) * 60 + parseInt(parts[1]);
                        }

                        function formatTime(minutes) {
                            var h = Math.floor(minutes / 60);
                            var m = minutes % 60;
                            return (h < 10 ? '0' + h : h) + ':' + (m < 10 ? '0' + m : m);
                        }

                        function renderSlots(selectedDate) {
                            timeSelect.innerHTML = '';

                            var defaultOpt = document.createElement('option');
                            defaultOpt.value = '';
                            defaultOpt.textContent = selectTimeLabel;
                            timeSelect.appendChild(defaultOpt);

                            var slots = generateTimeSlots();
                            var now = new Date();
                            var today = now.toISOString().split('T')[0];
                            var currentMinutes = now.getHours() * 60 + now.getMinutes();

                            slots.forEach(function(slot) {
                                if (selectedDate === today) {
                                    var slotMinutes = parseTime(slot);
                                    if (slotMinutes <= currentMinutes) return;
                                }
                                var opt = document.createElement('option');
                                opt.value = slot;
                                opt.textContent = slot;
                                timeSelect.appendChild(opt);
                            });

                            var oldValue = '{{ old("service_time", "") }}';
                            if (oldValue) {
                                timeSelect.value = oldValue;
                            }
                        }

                        dateInput.addEventListener('change', function() {
                            timeSelect.innerHTML = '';

                            if (!this.value) {
                                var opt = document.createElement('option');
                                opt.value = '';
                                opt.textContent = selectDateFirstLabel;
                                timeSelect.appendChild(opt);
                                return;
                            }

                            var selectedDate = new Date(this.value + 'T00:00:00');
                            var dayOfWeek = selectedDate.getDay();

                            // Validate within sale period
                            if ((saleEndDate && this.value > saleEndDate) || (saleStartDate && this.value < saleStartDate)) {
                                var opt = document.createElement('option');
                                opt.value = '';
                                opt.textContent = dateOutOfRangeLabel;
                                timeSelect.appendChild(opt);
                                timeSelect.classList.add('is-invalid');
                                return;
                            }

                            if (serviceDays.length > 0 && serviceDays.indexOf(dayOfWeek) === -1) {
                                var opt = document.createElement('option');
                                opt.value = '';
                                opt.textContent = dayNotAvailableLabel;
                                timeSelect.appendChild(opt);
                                timeSelect.classList.add('is-invalid');
                                return;
                            }

                            timeSelect.classList.remove('is-invalid');

                            renderSlots(this.value);
                        });

                        // Trigger on load if date is pre-filled
                        if (dateInput.value) {
                            dateInput.dispatchEvent(new Event('change'));
                        }
                    })();
                    </script>
                    @endif
                </div>
            </div>
        </div>

        {{-- Product Image Lightbox --}}
        <div id="product-lightbox" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.88); z-index:9999; align-items:center; justify-content:center; cursor:zoom-out;" onclick="closeProductLightbox()">
            <img id="product-lightbox-img" src="" alt="" style="max-width:90%; max-height:90vh; border-radius:8px; box-shadow:0 4px 40px rgba(0,0,0,0.6); cursor:default; user-select:none;" onclick="event.stopPropagation()">
            <button onclick="closeProductLightbox()" title="{{ __('Close') }}" style="position:fixed; top:18px; right:26px; background:rgba(255,255,255,0.15); border:none; color:#fff; font-size:2rem; width:44px; height:44px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; line-height:1; transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">&times;</button>
        </div>
        <script>
        function openProductLightbox(src, alt) {
            var lb = document.getElementById('product-lightbox');
            var img = document.getElementById('product-lightbox-img');
            img.src = src;
            img.alt = alt || '';
            lb.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        function closeProductLightbox() {
            document.getElementById('product-lightbox').style.display = 'none';
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeProductLightbox();
        });
        </script>

        @if ($product->content)
            <div class="row mt-50">
                <div class="col-12">
                    <div class="ck-content">
                        {!! $product->content !!}
                    </div>
                </div>
            </div>
        @endif

        @if ($relatedProducts->isNotEmpty())
            <div class="row mt-50">
                <div class="col-12">
                    <h3 class="mb-30">{{ __('Related Products') }}</h3>
                </div>
                @foreach ($relatedProducts as $relatedProduct)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-30">
                        @include(Theme::getThemeNamespace('views.product.partials.product-card'), ['product' => $relatedProduct])
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
