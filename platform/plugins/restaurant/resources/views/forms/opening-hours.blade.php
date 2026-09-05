{{--
    Bảng nhập khung giờ phục vụ: mỗi hàng gồm tên khung giờ, giờ bắt đầu /
    kết thúc kèm AM-PM và ngày áp dụng. Dấu + chèn hàng mới ngay dưới hàng đó,
    thùng rác chỉ hiện từ hàng thứ hai trở xuống.
--}}
@php
    use Illuminate\Support\Arr;

    $model = $model ?? null;
    $slots = $model && $model->id ? $model->openingHoursItemsArray() : [];

    if (! $slots) {
        $slots = [[]];
    }

    $hours = range(1, 12);
    $minutes = [];

    for ($minute = 0; $minute < 60; $minute += 5) {
        $minutes[] = str_pad((string) $minute, 2, '0', STR_PAD_LEFT);
    }

    $days = trans('plugins/restaurant::restaurant.days');
    $daysShort = trans('plugins/restaurant::restaurant.days_short');
@endphp

<style>
    .rst-hours__row {
        display: grid;
        grid-template-columns: minmax(150px, 1.3fr) auto minmax(215px, 1fr) auto;
        gap: 10px;
        align-items: end;
        padding: 12px;
        border: 1px solid var(--bs-border-color, #e6e7e9);
        border-radius: 6px;
        background: var(--bs-body-bg, #fff);
    }

    /* Bỏ mũi tên xuống mặc định của select cho đỡ chiếm chỗ trong ô hẹp */
    .rst-hours select.form-select {
        padding-inline: 10px;
        background-image: none;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        text-align: center;
        text-align-last: center;
    }

    .rst-hours__row + .rst-hours__row {
        margin-top: 10px;
    }

    .rst-hours__field {
        min-width: 0;
    }

    .rst-hours__field > label {
        display: block;
        margin-bottom: 4px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: var(--bs-secondary-color, #6c757d);
    }


    /* [giờ] : [phút] [AM/PM]  -  [giờ] : [phút] [AM/PM] */
    .rst-hours__time {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .rst-hours__clock {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .rst-hours__clock select {
        min-width: 0;
        width: auto;
    }

    .rst-hours__sep {
        flex: none;
        padding-inline: 2px;
        font-weight: 600;
        line-height: 1;
        color: var(--bs-secondary-color, #6c757d);
        user-select: none;
    }

    .rst-hours__sep--dash {
        padding-inline: 8px;
    }

    .rst-hours__actions {
        display: flex;
        gap: 6px;
        padding-bottom: 1px;
    }

    .rst-hours__actions .btn {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .rst-hours__actions .btn svg {
        width: 18px;
        height: 18px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* hộp chọn thứ */
    .rst-days-group + .rst-days-group {
        margin-top: 16px;
    }

    .rst-days-group__label {
        display: block;
        margin-bottom: 8px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: var(--bs-secondary-color, #6c757d);
    }

    .rst-days-chips {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
    }

    .rst-days-chips button {
        padding: 9px 4px;
        border: 1px solid var(--bs-border-color, #e6e7e9);
        border-radius: 6px;
        background: transparent;
        color: inherit;
        font-size: 13px;
        font-weight: 500;
        line-height: 1;
        cursor: pointer;
    }

    .rst-days-chips button.is-active {
        border-color: var(--bs-primary, #0d6efd);
        background: var(--bs-primary, #0d6efd);
        color: #fff;
    }

    @media (max-width: 991px) {
        .rst-hours__row {
            grid-template-columns: 1fr;
        }

        .rst-hours__actions {
            justify-content: flex-end;
        }
    }
</style>

<div class="rst-hours" data-rst-hours>
    @foreach ($slots as $index => $slot)
        @php
            $daysMode = Arr::get($slot, 'days_mode', 'daily');
        @endphp
        <div class="rst-hours__row" data-rst-hours-row data-days-mode="{{ $daysMode }}">
            <div class="rst-hours__field">
                <label>{{ trans('plugins/restaurant::restaurant.slot_label') }}</label>
                <input type="text" class="form-control" data-name="label"
                       name="opening_hours_items[{{ $index }}][label]"
                       value="{{ Arr::get($slot, 'label') }}"
                       placeholder="{{ trans('plugins/restaurant::restaurant.slot_label_placeholder') }}">
            </div>

            <div class="rst-hours__field">
                <label>{{ trans('plugins/restaurant::restaurant.slot_time') }}</label>
                <div class="rst-hours__time">
                    @foreach (['start', 'end'] as $edge)
                        @if ($edge === 'end')
                            <span class="rst-hours__sep rst-hours__sep--dash" aria-hidden="true">-</span>
                        @endif
                        <div class="rst-hours__clock"
                             title="{{ trans('plugins/restaurant::restaurant.slot_' . $edge) }}">
                            <select class="form-select" data-name="{{ $edge }}_hour"
                                    aria-label="{{ trans('plugins/restaurant::restaurant.slot_' . $edge) }}"
                                    name="opening_hours_items[{{ $index }}][{{ $edge }}_hour]">
                                <option value="">--</option>
                                @foreach ($hours as $hour)
                                    <option value="{{ $hour }}" @selected((string) Arr::get($slot, $edge . '_hour') === (string) $hour)>{{ $hour }}</option>
                                @endforeach
                            </select>
                            <span class="rst-hours__sep" aria-hidden="true">:</span>
                            <select class="form-select" data-name="{{ $edge }}_minute"
                                    name="opening_hours_items[{{ $index }}][{{ $edge }}_minute]">
                                @foreach ($minutes as $minute)
                                    <option value="{{ $minute }}" @selected((string) Arr::get($slot, $edge . '_minute', '00') === $minute)>{{ $minute }}</option>
                                @endforeach
                            </select>
                            <select class="form-select" data-name="{{ $edge }}_meridiem"
                                    name="opening_hours_items[{{ $index }}][{{ $edge }}_meridiem]">
                                @foreach (['am' => 'AM', 'pm' => 'PM'] as $value => $text)
                                    <option value="{{ $value }}" @selected(Arr::get($slot, $edge . '_meridiem', 'am') === $value)>{{ $text }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Một ô duy nhất. Chọn "Từ thứ … đến thứ …" thì mở hộp chọn thứ,
                 chọn xong nhãn của chính lựa chọn đó thành "T2 - T6". --}}
            @php
                $dayFrom = Arr::get($slot, 'day_from', 'mon');
                $dayTo = Arr::get($slot, 'day_to', 'sun');
                $rangeText = $daysMode === 'range'
                    ? Arr::get($daysShort, $dayFrom, $dayFrom) . ' - ' . Arr::get($daysShort, $dayTo, $dayTo)
                    : trans('plugins/restaurant::restaurant.days_range_mode');
            @endphp
            <div class="rst-hours__field">
                <label>{{ trans('plugins/restaurant::restaurant.slot_days') }}</label>
                <select class="form-select" data-name="days_mode" data-rst-days-mode
                        name="opening_hours_items[{{ $index }}][days_mode]">
                    <option value="daily" @selected($daysMode !== 'range')>{{ trans('plugins/restaurant::restaurant.days_daily') }}</option>
                    <option value="range" data-rst-range-option @selected($daysMode === 'range')>{{ $rangeText }}</option>
                </select>
                <input type="hidden" data-name="day_from" value="{{ $dayFrom }}"
                       name="opening_hours_items[{{ $index }}][day_from]">
                <input type="hidden" data-name="day_to" value="{{ $dayTo }}"
                       name="opening_hours_items[{{ $index }}][day_to]">
            </div>

            {{-- SVG nội tuyến: admin không nạp webfont Tabler nên <i class="ti ti-*"> ra ô trống --}}
            <div class="rst-hours__actions">
                <button type="button" class="btn btn-primary" data-rst-hours-add
                        aria-label="{{ trans('plugins/restaurant::restaurant.slot_add') }}"
                        title="{{ trans('plugins/restaurant::restaurant.slot_add') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                </button>
                <button type="button" class="btn btn-outline-danger" data-rst-hours-remove
                        aria-label="{{ trans('plugins/restaurant::restaurant.slot_remove') }}"
                        title="{{ trans('plugins/restaurant::restaurant.slot_remove') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 7h16M10 11v6M14 11v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                    </svg>
                </button>
            </div>
        </div>
    @endforeach
</div>

{{-- Hộp chọn thứ dùng chung cho mọi hàng --}}
<div class="modal fade" tabindex="-1" data-rst-days-modal>
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('plugins/restaurant::restaurant.days_pick_title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        data-rst-days-close aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach (['from' => 'days_from', 'to' => 'days_to'] as $edge => $labelKey)
                    <div class="rst-days-group">
                        <span class="rst-days-group__label">{{ trans('plugins/restaurant::restaurant.' . $labelKey) }}</span>
                        <div class="rst-days-chips" data-rst-days-chips="{{ $edge }}">
                            @foreach ($daysShort as $value => $text)
                                <button type="button" data-day="{{ $value }}"
                                        title="{{ Arr::get($days, $value, $value) }}">{{ $text }}</button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100" data-rst-days-apply>
                    {{ trans('plugins/restaurant::restaurant.days_apply') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var root = document.querySelector('[data-rst-hours]');

        if (!root) {
            return;
        }

        var DAY_SHORT = @json($daysShort);

        function rows() {
            return Array.prototype.slice.call(root.querySelectorAll('[data-rst-hours-row]'));
        }

        // Đánh lại chỉ số name[] theo thứ tự hiện tại và ẩn thùng rác ở hàng đầu.
        function refresh() {
            rows().forEach(function (row, index) {
                row.querySelectorAll('[data-name]').forEach(function (field) {
                    field.name = 'opening_hours_items[' + index + '][' + field.getAttribute('data-name') + ']';
                });

                var remove = row.querySelector('[data-rst-hours-remove]');

                if (remove) {
                    remove.style.display = index === 0 ? 'none' : '';
                }
            });
        }

        var RANGE_LABEL = @json(trans('plugins/restaurant::restaurant.days_range_mode'));

        // Ghi cặp thứ vào input ẩn, rồi đổi luôn nhãn của lựa chọn "từ … đến …"
        // thành "T2 - T6" để ô chọn hiện kết quả, không cần thêm ô nào nữa.
        function setRange(row, from, to) {
            var fromInput = row.querySelector('[data-name="day_from"]');
            var toInput = row.querySelector('[data-name="day_to"]');
            var option = row.querySelector('[data-rst-range-option]');

            if (!fromInput || !toInput || !option) {
                return;
            }

            fromInput.value = from;
            toInput.value = to;
            option.textContent = (DAY_SHORT[from] || from) + ' - ' + (DAY_SHORT[to] || to);
        }

        function resetRange(row) {
            var option = row.querySelector('[data-rst-range-option]');

            if (option) {
                option.textContent = RANGE_LABEL;
            }

            var fromInput = row.querySelector('[data-name="day_from"]');
            var toInput = row.querySelector('[data-name="day_to"]');

            if (fromInput) {
                fromInput.value = 'mon';
            }

            if (toInput) {
                toInput.value = 'sun';
            }
        }

        function blankRow(source) {
            var row = source.cloneNode(true);

            row.setAttribute('data-days-mode', 'daily');
            row.querySelectorAll('input[data-name]').forEach(function (input) {
                input.value = '';
            });
            row.querySelectorAll('select[data-name]').forEach(function (select) {
                select.selectedIndex = 0;
            });
            resetRange(row);

            return row;
        }

        root.addEventListener('click', function (event) {
            var add = event.target.closest('[data-rst-hours-add]');

            if (add) {
                var current = add.closest('[data-rst-hours-row]');
                current.after(blankRow(current));
                refresh();

                return;
            }

            var remove = event.target.closest('[data-rst-hours-remove]');

            if (remove && rows().length > 1) {
                remove.closest('[data-rst-hours-row]').remove();
                refresh();
            }
        });

        /* --------------------------------------- hộp chọn ngày áp dụng */

        var modal = document.querySelector('[data-rst-days-modal]');
        var targetRow = null;
        var instance = null;
        var applied = false;

        function mark(edge, value) {
            modal.querySelectorAll('[data-rst-days-chips="' + edge + '"] button').forEach(function (chip) {
                chip.classList.toggle('is-active', chip.getAttribute('data-day') === value);
            });
        }

        function picked(edge, fallback) {
            var active = modal.querySelector('[data-rst-days-chips="' + edge + '"] button.is-active');

            return active ? active.getAttribute('data-day') : fallback;
        }

        function revertIfNotApplied() {
            if (applied || !targetRow) {
                return;
            }

            var select = targetRow.querySelector('[data-rst-days-mode]');

            if (select) {
                select.value = 'daily';
            }
        }

        // Bootstrap có sẵn ở trang quản trị, nhưng vẫn để đường lui phòng khi thiếu.
        function toggleModal(show) {
            if (window.bootstrap && window.bootstrap.Modal) {
                instance = instance || new window.bootstrap.Modal(modal);
                instance[show ? 'show' : 'hide']();

                return;
            }

            modal.classList.toggle('show', show);
            modal.style.display = show ? 'block' : 'none';
            modal.style.background = show ? 'rgba(0, 0, 0, .5)' : '';

            if (! show) {
                revertIfNotApplied();
            }
        }

        // Chọn "Từ thứ … đến thứ …" thì mở hộp chọn thứ; đóng ngang mà chưa
        // chọn xong thì trả ô về "Hàng ngày" để khỏi lưu khoảng thứ dở dang.
        root.addEventListener('change', function (event) {
            var select = event.target.closest('[data-rst-days-mode]');

            if (!select || select.value !== 'range' || !modal) {
                return;
            }

            targetRow = select.closest('[data-rst-hours-row]');
            applied = false;
            mark('from', (targetRow.querySelector('[data-name="day_from"]') || {}).value || 'mon');
            mark('to', (targetRow.querySelector('[data-name="day_to"]') || {}).value || 'sun');
            toggleModal(true);
        });

        if (modal) {
            modal.addEventListener('click', function (event) {
                var chip = event.target.closest('[data-rst-days-chips] button');

                if (chip) {
                    mark(chip.parentElement.getAttribute('data-rst-days-chips'), chip.getAttribute('data-day'));

                    return;
                }

                if (event.target.closest('[data-rst-days-apply]')) {
                    if (targetRow) {
                        setRange(targetRow, picked('from', 'mon'), picked('to', 'sun'));
                    }

                    applied = true;
                    toggleModal(false);

                    return;
                }

                if (event.target.closest('[data-rst-days-close]') || event.target === modal) {
                    toggleModal(false);
                }
            });

            modal.addEventListener('hidden.bs.modal', revertIfNotApplied);
        }

        refresh();
    })();
</script>
