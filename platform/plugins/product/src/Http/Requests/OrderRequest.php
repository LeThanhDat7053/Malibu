<?php

namespace Botble\Product\Http\Requests;

use Botble\Product\Models\Product;
use Botble\Support\Http\Requests\Request;
use Carbon\Carbon;

class OrderRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'product_id' => ['required', 'exists:ht_products,id'],
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_email' => ['required', 'email', 'max:120'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
            'customer_note' => ['nullable', 'string', 'max:1000'],
        ];

        $product = Product::query()->find($this->input('product_id'));

        if ($product && $product->enable_booking) {
            $dateRules = ['required', 'date', 'after_or_equal:today'];

            if ($product->sale_start_date) {
                $dateRules[] = 'after_or_equal:' . $product->sale_start_date->format('Y-m-d');
            }

            if ($product->sale_end_date) {
                $dateRules[] = 'before_or_equal:' . $product->sale_end_date->format('Y-m-d');
            }

            $rules['service_date'] = $dateRules;
            $rules['service_time'] = ['required', 'date_format:H:i'];
        }

        return $rules;
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $product = Product::query()->find($this->input('product_id'));

            if (! $product || ! $product->enable_booking) {
                return;
            }

            $serviceDate = $this->input('service_date');
            $serviceTime = $this->input('service_time');

            if (! $serviceDate || ! $serviceTime) {
                return;
            }

            // Validate day of week
            $dayOfWeek = Carbon::parse($serviceDate)->dayOfWeek;
            $allowedDays = $product->service_days ?? [];

            if (! empty($allowedDays) && ! in_array($dayOfWeek, $allowedDays)) {
                $validator->errors()->add('service_date', trans('plugins/product::product.validation.day_not_available'));
            }

            // Validate time within service hours
            if ($product->service_start_time && $product->service_end_time) {
                $selectedMinutes = $this->timeToMinutes($serviceTime);
                $startMinutes = $this->timeToMinutes($product->service_start_time);
                $endMinutes = $this->timeToMinutes($product->service_end_time);

                if ($selectedMinutes < $startMinutes || $selectedMinutes >= $endMinutes) {
                    $validator->errors()->add('service_time', trans('plugins/product::product.validation.time_not_available'));
                }
            }

        });
    }

    private function timeToMinutes(string $time): int
    {
        $parts = explode(':', $time);

        return (int) $parts[0] * 60 + (int) ($parts[1] ?? 0);
    }
}
