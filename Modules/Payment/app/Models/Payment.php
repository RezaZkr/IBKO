<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Order\Models\Order;
use Modules\Payment\Enums\PaymentStatusEnum;
use Modules\Payment\Observers\PaymentObserver;

#[
    ObservedBy(PaymentObserver::class),
    Fillable(['order_id', 'token', 'amount', 'status', 'ref_id']),
]
class Payment extends Model
{
    protected function casts(): array
    {
        return [
            'status' => PaymentStatusEnum::class,
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
