<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Customer\Models\Customer;
use Modules\Order\Enums\OrderPaymentStatusEnum;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Order\Observers\OrderObserver;

#[
    ObservedBy(OrderObserver::class),
    Fillable(['customer_id', 'order_number', 'total_amount', 'status', 'payment_status', 'paid_at'])
]
class Order extends Model
{
    protected function casts(): array
    {
        return [
            'status'         => OrderStatusEnum::class,
            'payment_status' => OrderPaymentStatusEnum::class,
            'paid_at'        => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
