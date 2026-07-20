<?php

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\Product;

class ProductVariantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Product\Models\ProductVariant::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'sku'        => 'SKU-' . strtoupper(fake()->bothify('###??')),
            'price'      => fake()->numberBetween(1000000, 50000000),
            'quantity'   => 10,
        ];
    }
}

