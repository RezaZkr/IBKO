<?php

namespace Modules\Order\Observers;

use Modules\Order\Models\OrderItem;

class OrderItemObserver
{
    public function saving(OrderItem $orderitem): void {
        $orderitem->total_price = $orderitem->price * $orderitem->quantity;
    }

}
