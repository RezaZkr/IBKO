<?php

namespace Modules\Order\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Customer\Models\Customer;
use Modules\Order\Enums\OrderPaymentStatusEnum;
use Modules\Order\Enums\OrderStatusEnum;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Order\Models\Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id'    => Customer::factory(),
            'total_amount'   => fake()->numberBetween(10000, 90000000),
            'status'         => fake()->randomElement(OrderStatusEnum::cases()),
            'payment_status' => fake()->randomElement(OrderPaymentStatusEnum::cases()),
        ];
    }
}

