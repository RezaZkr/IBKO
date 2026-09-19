<?php

namespace Modules\Order\Services;

use Illuminate\Support\Facades\DB;
use Modules\Customer\Models\Customer;
use Modules\Order\Enums\OrderPaymentStatusEnum;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Order\Exceptions\InsufficientStockException;
use Modules\Order\Exceptions\VariantUnavailableException;
use Modules\Order\Models\Order;
use Modules\Order\Models\OrderItem;
use Modules\Product\Models\ProductVariant;

class OrderService
{
    public function createOrder(Customer $customer, array $items): Order
    {
        $normalizedItems = $this->normalizeItems($items);

        return DB::transaction(function () use ($customer, $normalizedItems) {

            $order = Order::create([
                'customer_id'  => $customer->id,
                'total_amount' => 0,
            ]);

            $totalAmount = 0;

            ksort($normalizedItems);

            foreach ($normalizedItems as $variantId => $quantity) {

                $variant = ProductVariant::query()
                    ->with('attributeValues.attribute')
                    ->where('id', $variantId)
                    ->lockForUpdate()
                    ->first();

                if (!$variant) {
                    throw new VariantUnavailableException($variantId);
                }

                if ($variant->quantity < $quantity) {
                    throw new InsufficientStockException($variantId);
                }

//                $variant->decrement('quantity', $quantity);todo decrement after payment success

                $attributesSnapshot = $variant->attributeValues
                    ->map(fn($av) => [
                        'name'  => $av->attribute->name,
                        'value' => $av->name,
                    ])->toArray();

                $itemTotal = $variant->price * $quantity;

                OrderItem::create([
                    'order_id'            => $order->id,
                    'product_variant_id'  => $variant->id,
                    'product_title'       => $variant->product->title,
                    'sku'                 => $variant->sku,
                    'price'               => $variant->price,
                    'quantity'            => $quantity,
                    'total_price'         => $itemTotal,
                    'attributes_snapshot' => $attributesSnapshot,
                ]);

                $totalAmount += $itemTotal;
            }

            $order->update(['total_amount' => $totalAmount]);

            return $order->load('items');
        });
    }

    private function normalizeItems(array $items): array
    {
        $result = [];

        foreach ($items as $item) {
            $variantId = (int)$item['variant_id'];
            $quantity = (int)$item['quantity'];

            $result[$variantId] = ($result[$variantId] ?? 0) + $quantity;
        }

        return $result;
    }

    public function confirmPayment(Order $order): void
    {
        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                if (!$item->product_variant_id) continue;

                $variant = ProductVariant::query()
                    ->where('id', $item->product_variant_id)
                    ->lockForUpdate()
                    ->first();

                $variant?->decrement('quantity', $item->quantity);
            }

            $order->update([
                'payment_status' => OrderPaymentStatusEnum::Paid,
                'status'         => OrderStatusEnum::Processing,
                'paid_at'        => now(),
            ]);
        });
    }
}
