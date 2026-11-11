<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_name' => fake()->sentence(3),
            'product_description' => fake()->paragraph(),
            'product_price' => fake()->randomFloat(2, 100, 5000),
            'ticket_quota' => fake()->numberBetween(10, 100),
            'departure_date' => now()->addDays(fake()->numberBetween(10, 365)),
            'departure_locations' => fake()->city(),
            'product_image' => [],
            'is_published' => true,
        ];
    }
}
