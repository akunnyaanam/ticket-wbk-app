<?php

namespace Database\Factories;

use App\Models\Category;
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
            'category_id' => Category::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraphs(3, true),
            'location' => fake()->word(),
            'datetime' => fake()->dateTimeBetween('-1 week', '+1 week'),
            'image_path' => null,
        ];
    }
}
