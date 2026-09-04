<?php

namespace Botble\Product\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProductRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:400'],
            'content' => ['nullable', 'string', 'max:100000'],
            'price' => ['required', 'numeric', 'min:0'],
            'original_price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:ht_product_categories,id'],
            'order' => ['nullable', 'numeric'],
            'status' => Rule::in(BaseStatusEnum::values()),
            'sale_start_date' => ['nullable', 'date'],
            'sale_end_date' => ['nullable', 'date', 'after_or_equal:sale_start_date'],
            'enable_booking' => ['nullable', 'boolean'],
            'service_start_time' => ['nullable', 'date_format:H:i,H:i:s'],
            'service_end_time' => ['nullable', 'date_format:H:i,H:i:s', 'after:service_start_time'],
            'service_days' => ['nullable', 'array'],
            'service_days.*' => ['integer', 'min:0', 'max:6'],
            'time_slot_duration' => ['nullable', 'integer', Rule::in([30, 60, 90, 120])],
        ];
    }
}
