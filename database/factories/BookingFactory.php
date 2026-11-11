<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'booking_reference' => 'BKG-'.now()->format('Ymd').'-'.strtoupper(fake()->unique()->lexify('????????')),
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'quantity' => 1,
            'total_price' => fake()->randomFloat(2, 100, 5000),
            'status' => 'unpaid',
            'stripe_session_id' => 'cs_test_'.fake()->unique()->lexify('????????????????????'),
            'contact_email' => fake()->email(),
            'contact_phone' => fake()->phoneNumber(),
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
        ]);
    }
}
