<?php

namespace Database\Factories;

use App\Models\;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => ::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->text(),
            'location' => fake()->word(),
            'datetime' => fake()->dateTime(),
            'image_path' => fake()->word(),
        ];
    }
}
