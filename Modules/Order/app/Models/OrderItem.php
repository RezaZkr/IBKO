<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Order\Database\Factories\OrderItemFactory;
use Modules\Order\Observers\OrderItemObserver;
use Modules\Product\Models\ProductVariant;

#[
    ObservedBy(OrderItemObserver::class),
    Fillable(['order_id', 'product_variant_id', 'product_title', 'sku', 'price', 'quantity', 'total_price', 'attributes_snapshot']),
    UseFactory(OrderItemFactory::class)

]
class OrderItem extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'attributes_snapshot' => 'array',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
