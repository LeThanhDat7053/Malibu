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
