<?php

namespace Botble\Product\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductOrder extends BaseModel
{
    protected $table = 'ht_product_orders';

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_note',
        'service_date',
        'service_time',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'service_date' => 'date',
    ];

    protected static function booted(): void
    {
        static::deleting(function (ProductOrder $order) {
            $order->items()->delete();
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProductOrderItem::class, 'order_id');
    }
}
