<?php

namespace Botble\Restaurant\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class RestaurantRequest extends Request
{
    public const DAYS = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

    /**
     * Các mốc phút cho chọn, bước 5 phút — trùng danh sách dựng ở form nhập.
     *
     * @return array<int, string>
     */
    public static function minutes(): array
    {
        $minutes = [];

        for ($minute = 0; $minute < 60; $minute += 5) {
            $minutes[] = str_pad((string) $minute, 2, '0', STR_PAD_LEFT);
        }

        return $minutes;
    }

    /**
     * Hàng nào chưa chọn giờ bắt đầu thì bỏ đi, khỏi lưu khung giờ rỗng.
     */
    protected function prepareForValidation(): void
    {
        $items = $this->input('opening_hours_items');

        if (! is_array($items)) {
            return;
        }

        $items = array_values(array_filter(
            $items,
            fn ($item) => is_array($item) && filled($item['start_hour'] ?? null)
        ));

        $this->merge(['opening_hours_items' => $items]);
    }

    /**
     * Model không có mutator cho cột này (đụng macro dịch đa ngôn ngữ) nên
     * mã hoá JSON ngay tại đây, sau khi mảng đã qua validate.
     */
    protected function passedValidation(): void
    {
        $items = $this->input('opening_hours_items');

        if (is_array($items)) {
            $this->merge([
                'opening_hours_items' => json_encode($items, JSON_UNESCAPED_UNICODE),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:400'],
            'content' => ['nullable', 'string', 'max:100000'],
            'location' => ['nullable', 'string', 'max:120'],
            'capacity' => ['nullable', 'string', 'max:120'],
            'opening_hours' => ['nullable', 'string', 'max:160'],
            'opening_hours_items' => ['nullable', 'array', 'max:20'],
            'opening_hours_items.*.label' => ['nullable', 'string', 'max:120'],
            'opening_hours_items.*.start_hour' => ['nullable', 'integer', 'between:1,12'],
            'opening_hours_items.*.end_hour' => ['nullable', 'integer', 'between:1,12'],
            // phút gửi lên dạng '00', '05'… nên rule integer trượt (số 0 ở đầu)
            'opening_hours_items.*.start_minute' => ['nullable', Rule::in(self::minutes())],
            'opening_hours_items.*.end_minute' => ['nullable', Rule::in(self::minutes())],
            'opening_hours_items.*.start_meridiem' => ['nullable', Rule::in(['am', 'pm'])],
            'opening_hours_items.*.end_meridiem' => ['nullable', Rule::in(['am', 'pm'])],
            'opening_hours_items.*.days_mode' => ['nullable', Rule::in(['daily', 'range'])],
            'opening_hours_items.*.day_from' => ['nullable', Rule::in(self::DAYS)],
            'opening_hours_items.*.day_to' => ['nullable', Rule::in(self::DAYS)],
            'cuisine' => ['nullable', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:60'],
            'email' => ['nullable', 'email', 'max:120'],
            'vr360_url' => ['nullable', 'string', 'max:500'],
            'is_featured' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
