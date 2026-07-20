<?php

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Category\Models\Category;
use Modules\General\Enums\BooleanEnum;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Product\Models\Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title'       => $this->faker->sentence,
            'slug'        => fake()->unique()->slug,
            'category_id' => Category::factory(),
            'description' => fake()->text,
            'status'      => fake()->randomElement(BooleanEnum::cases())
        ];
    }
}

