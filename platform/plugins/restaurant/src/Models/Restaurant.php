<?php

namespace Botble\Restaurant\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Support\Arr;

/**
 * @property string $name
 * @property string|null $description
 * @property string|null $content
 * @property array $images
 * @property array $videos
 * @property string|null $vr360_url
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
        'description',
        'content',
        'images',
        'videos',
        'vr360_url',
        'location',
        'capacity',
        'opening_hours',
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

    public function getVideosAttribute($value): array
    {
        return $this->decodeJsonList($value);
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
