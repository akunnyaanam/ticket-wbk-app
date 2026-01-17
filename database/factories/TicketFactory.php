<?php

namespace Database\Factories;

use App\Enums\TicketType;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $type = collect(TicketType::cases())->pluck('value')->toArray();

        return [
            'event_id' => Event::factory(),
            'type' => fake()->randomElement($type),
            'price' => fake()->randomFloat(2, 0, 9999999999.99),
            'stock' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
