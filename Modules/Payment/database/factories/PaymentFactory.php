<?php

namespace Modules\Payment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Order\Models\Order;
use Modules\Payment\Enums\PaymentStatusEnum;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Payment\Models\Payment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'token'    => fake()->uuid(),
            'amount'   => fake()->numberBetween(100000, 1000000),
            'status'   => fake()->randomElement(PaymentStatusEnum::cases()),
        ];
    }
}

