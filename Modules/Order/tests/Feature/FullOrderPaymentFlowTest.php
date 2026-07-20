<?php

namespace Modules\Order\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Customer\Models\Customer;
use Modules\Order\Enums\OrderPaymentStatusEnum;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Order\Models\Order;
use Modules\Product\Models\ProductVariant;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class FullOrderPaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_flow_from_order_creation_to_successful_payment(): void
    {
        $variant = ProductVariant::factory()->create([
            'price'    => 32_500_000,
            'quantity' => 10,
        ]);
        $user = Customer::factory()->create();

        $orderResponse = $this->actingAs($user)->postJson(route('api.public.orders.store'),['items' => [['variant_id' => $variant->id, 'quantity' => 2]]]);

        $orderResponse->assertStatus(ResponseAlias::HTTP_CREATED)
            ->assertJsonPath('data.order.total_amount', 65_000_000)
            ->assertJsonPath('data.order.status.value', OrderStatusEnum::Pending->value)
            ->assertJsonPath('data.order.payment_status.value', OrderPaymentStatusEnum::Unpaid->value);

        $orderNumber = $orderResponse->json('data.order.order_number');
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $variant->refresh();
        $this->assertSame(10, $variant->quantity);

        $payResponse = $this->actingAs($user)->postJson(route('api.public.payments.pay',['order'=>$order->order_number]));

        $payResponse->assertStatus(ResponseAlias::HTTP_OK)->assertJsonStructure([
            'data' => [
                'payment_url', 'token', 'amount'
            ]
        ]);

        $token = $payResponse->json('data.token');

        $callbackResponse = $this->post(route('api.public.payments.callback', ['token' => $token]),[
            'result' => 'success',
        ]);
        $callbackResponse->assertRedirect();

        $order->refresh();
        $this->assertSame(OrderPaymentStatusEnum::Paid->value, $order->payment_status->value);
        $this->assertSame(OrderStatusEnum::Processing->value, $order->status->value);
        $this->assertNotNull($order->paid_at);

        $variant->refresh();
        $this->assertSame(8, $variant->quantity);

        $this->assertDatabaseHas('order_items', [
            'order_id'           => $order->id,
            'product_variant_id' => $variant->id,
            'price'              => 32_500_000,
            'quantity'           => 2,
            'total_price'        => 65_000_000,
        ]);
    }
}
