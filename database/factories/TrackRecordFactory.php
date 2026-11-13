<?php

namespace Database\Factories;

use App\Models\TrackRecord;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TrackRecord>
 */
class TrackRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $city = fake()->city();
        $year = fake()->year();

        return [
            'city_name' => $city,
            'description' => fake()->paragraph(),
            'year' => $year,
            'banner_image' => 'travel-records/banners/placeholder.jpg',
            'slug' => Str::slug($city.'-'.$year.'-'.fake()->word()),
        ];
    }
}
