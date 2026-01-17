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
            'price' => fake()->numberBetween(1, 9) * 10000,
            'stock' => fake()->numberBetween(1, 9) * 10,
        ];
    }
}
