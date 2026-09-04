<?php

namespace Botble\Restaurant\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class RestaurantRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:400'],
            'content' => ['nullable', 'string', 'max:100000'],
            'location' => ['nullable', 'string', 'max:120'],
            'capacity' => ['nullable', 'string', 'max:120'],
            'opening_hours' => ['nullable', 'string', 'max:160'],
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
