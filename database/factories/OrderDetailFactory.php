<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'ticket_id' => Ticket::factory(),
            'quantity' => fake()->numberBetween(-10000, 10000),
            'sub_total' => fake()->randomFloat(2, 0, 9999999999.99),
        ];
    }
}
