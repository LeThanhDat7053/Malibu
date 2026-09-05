<?php

namespace Botble\Restaurant\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Support\Arr;

/**
 * @property string $name
 * @property string|null $subtitle
 * @property string|null $description
 * @property string|null $content
 * @property array $images
 * @property string|null $banner_image
 * @property array $menu_images
 * @property string|null $menu_heading
 * @property array $videos
 * @property string|null $vr360_url
 * @property string|null $vr360_embed
 * @property string|null $location
 * @property string|null $capacity
 * @property string|null $opening_hours
 * @property string|null $cuisine
 * @property string|null $phone
 * @property string|null $email
 */
class Restaurant extends BaseModel
{
    protected $table = 'ht_restaurants';

    protected $fillable = [
        'name',
        'subtitle',
        'description',
        'content',
        'images',
        'banner_image',
        'menu_images',
        'menu_heading',
        'videos',
        'vr360_url',
        'vr360_embed',
        'location',
        'capacity',
        'opening_hours',
        'opening_hours_items',
        'cuisine',
        'phone',
        'email',
        'is_featured',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    public function getImagesAttribute($value): array
    {
        return $this->decodeJsonList($value);
    }

    /**
     * Ảnh đại diện dùng ở thẻ danh sách và thẻ chia sẻ mạng xã hội.
     */
    public function getImageAttribute(): ?string
    {
        return Arr::first($this->images) ?: null;
    }

    public function getMenuImagesAttribute($value): array
    {
        return $this->decodeJsonList($value);
    }

    /**
     * Ảnh hero khổ lớn. Chưa nhập thì lấy tạm ảnh đầu của gallery.
     */
    public function getBannerAttribute(): ?string
    {
        return $this->banner_image ?: $this->image;
    }

    public function getVideosAttribute($value): array
    {
        return $this->decodeJsonList($value);
    }

    /**
     * Khung giờ phục vụ đã nhập ở trang quản trị, mỗi mục là một hàng của
     * bảng nhập giờ: label, start_hour/start_minute/start_meridiem,
     * end_*, days_mode ('daily' | 'range'), day_from, day_to.
     *
     * Cột này được đăng ký dịch đa ngôn ngữ nên KHÔNG đặt accessor tên
     * getOpeningHoursItemsAttribute(): LanguageAdvanced sinh macro cùng tên
     * và gọi không tham số. Đọc qua $this->opening_hours_items để lấy đúng
     * bản dịch của ngôn ngữ đang xem, rồi giải mã ở đây.
     *
     * @return array<int, array<string, string>>
     */
    public function openingHoursItemsArray(): array
    {
        $items = $this->decodeJsonList($this->opening_hours_items);

        return array_values(array_filter($items, fn ($item) => is_array($item)));
    }

    /**
     * Khung giờ đã dựng sẵn chuỗi để hiển thị ngoài trang.
     * Chưa nhập khung giờ nào thì lấy tạm chuỗi opening_hours cũ.
     *
     * @return array<int, array{label: string|null, time: string, days: string|null}>
     */
    public function getOpeningHoursSlotsAttribute(): array
    {
        $slots = [];

        foreach ($this->openingHoursItemsArray() as $item) {
            $time = $this->formatTimeRange($item);

            if (! $time) {
                continue;
            }

            $slots[] = [
                'label' => Arr::get($item, 'label') ?: null,
                'time' => $time,
                'days' => $this->formatDays($item),
            ];
        }

        if (! $slots && $this->opening_hours) {
            $slots[] = ['label' => null, 'time' => $this->opening_hours, 'days' => null];
        }

        return $slots;
    }

    protected function formatTimeRange(array $item): ?string
    {
        $start = $this->formatClock(
            Arr::get($item, 'start_hour'),
            Arr::get($item, 'start_minute'),
            Arr::get($item, 'start_meridiem')
        );

        $end = $this->formatClock(
            Arr::get($item, 'end_hour'),
            Arr::get($item, 'end_minute'),
            Arr::get($item, 'end_meridiem')
        );

        if (! $start) {
            return null;
        }

        return $end ? $start . ' – ' . $end : $start;
    }

    protected function formatClock($hour, $minute, $meridiem): ?string
    {
        if (! filled($hour)) {
            return null;
        }

        $clock = (int) $hour . ':' . str_pad((string) ($minute ?: '0'), 2, '0', STR_PAD_LEFT);

        return $meridiem ? $clock . strtolower((string) $meridiem) : $clock;
    }

    protected function formatDays(array $item): ?string
    {
        if (Arr::get($item, 'days_mode', 'daily') !== 'range') {
            return trans('plugins/restaurant::restaurant.days_daily');
        }

        $from = Arr::get($item, 'day_from');
        $to = Arr::get($item, 'day_to');

        if (! $from || ! $to) {
            return trans('plugins/restaurant::restaurant.days_daily');
        }

        // tên thứ viết tắt cho gọn ô hiển thị, dùng chung mọi ngôn ngữ
        $days = trans('plugins/restaurant::restaurant.days_short');

        return trans('plugins/restaurant::restaurant.days_range', [
            'from' => Arr::get($days, $from, $from),
            'to' => Arr::get($days, $to, $to),
        ]);
    }

    /**
     * Các mục thông tin ngắn hiển thị thành lưới ở trang chi tiết.
     *
     * @return array<int, array{label: string, value: string}>
     */
    public function getFactsAttribute(): array
    {
        $facts = [
            'restaurant.location' => $this->location,
            'restaurant.capacity' => $this->capacity,
            'restaurant.opening_hours' => $this->opening_hours,
            'restaurant.cuisine' => $this->cuisine,
        ];

        $result = [];

        foreach ($facts as $key => $value) {
            if (! $value) {
                continue;
            }

            $result[] = [
                'label' => trans('plugins/restaurant::' . $key),
                'value' => $value,
            ];
        }

        return $result;
    }

    protected function decodeJsonList($value): array
    {
        if (empty($value) || $value === '[null]') {
            return [];
        }

        if (is_array($value)) {
            return array_values(array_filter($value));
        }

        $decoded = json_decode((string) $value, true);

        return is_array($decoded) ? array_values(array_filter($decoded)) : [];
    }
}
