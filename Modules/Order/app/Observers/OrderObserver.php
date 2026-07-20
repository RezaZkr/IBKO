<?php

namespace Modules\Order\Observers;

use Illuminate\Support\Str;
use Modules\Order\Models\Order;

class OrderObserver
{
    public function creating(Order $order): void
    {
        if (blank($order->order_number)) {
            $order->order_number = $this->generateOrderNumber($order->customer_id);
        }
    }

    private function generateOrderNumber($id): string
    {
        do {
            $number = 'ORD-' . now()->format('ymd') . '-' . $id . strtoupper(Str::random(6));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
