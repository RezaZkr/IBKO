<?php

namespace Modules\Order\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Customer\Models\Customer;
use Modules\Product\Models\ProductVariant;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class InsufficientStockTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_is_rejected_and_fully_rolled_back_when_stock_is_insufficient(): void
    {
        $variant = ProductVariant::factory()->create([
            'quantity' => 2,
        ]);
        $user = Customer::factory()->create();

        $response = $this->actingAs($user)->postJson(route('api.public.orders.store'), [
            'items' => [['variant_id' => $variant->id, 'quantity' => 5]],
        ]);

        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);

        $variant->refresh();
        $this->assertSame(2, $variant->quantity);
    }

    public function test_order_with_multiple_items_fails_entirely_if_any_single_item_lacks_stock(): void
    {
        $variantA = ProductVariant::factory()->create(['quantity' => 10]);
        $variantB = ProductVariant::factory()->create(['quantity' => 1]);
        $user = Customer::factory()->create();

        $response = $this->actingAs($user)->postJson(route('api.public.orders.store'), [
            'items' => [
                ['variant_id' => $variantA->id, 'quantity' => 3],
                ['variant_id' => $variantB->id, 'quantity' => 2],
            ],
        ]);

        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);
    }
}
