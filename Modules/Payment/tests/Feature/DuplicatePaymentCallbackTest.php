<?php

namespace Modules\Payment\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Customer\Models\Customer;
use Modules\Order\Models\Order;
use Modules\Order\Models\OrderItem;
use Modules\Payment\Enums\PaymentStatusEnum;
use Modules\Payment\Models\Payment;
use Modules\Product\Models\ProductVariant;
use Tests\TestCase;

class DuplicatePaymentCallbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_processing_the_same_successful_callback_twice_does_not_double_decrement_stock(): void
    {
        $variant = ProductVariant::factory()->create(['quantity' => 10]);
        $user = Customer::factory()->create();

        $order = Order::factory()->create([
            'customer_id'  => $user->id,
            'total_amount' => 65_000_000,
        ]);
        OrderItem::factory()->create([
            'order_id'           => $order->id,
            'product_variant_id' => $variant->id,
            'quantity'           => 2,
            'price'              => $variant->price,
        ]);

        $payment = Payment::factory()->create([
            'order_id' => $order->id,
            'amount'   => 65_000_000,
            'status'   => PaymentStatusEnum::Pending,
        ]);

        $this->post(route('api.public.payments.callback', ['token' => $payment->token]), ['result' => 'success'])
            ->assertRedirect();

        $variant->refresh();
        $this->assertSame(8, $variant->quantity);

        $this->post(route('api.public.payments.callback', ['token' => $payment->token]), ['result' => 'success'])
            ->assertRedirect();

        $variant->refresh();
        $this->assertSame(8, $variant->quantity);

        $this->assertSame(1, Payment::where('order_id', $order->id)->where('status', PaymentStatusEnum::Success)->count());
    }
}
