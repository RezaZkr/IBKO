<?php

namespace Modules\Order\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Order\Models\Order;
use Modules\Product\Models\ProductVariant;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Order\Models\OrderItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'order_id'            => Order::factory(),
            'product_variant_id'  => ProductVariant::factory(),
            'product_title'       => fake()->sentence,
            'sku'                 => fake()->word,
            'price'               => fake()->numberBetween(10000, 95451145),
            'quantity'            => fake()->numberBetween(1, 10),
            'total_price'         => fake()->numberBetween(10000, 95451145),
            'attributes_snapshot' => []
        ];
    }
}

