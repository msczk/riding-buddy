<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Balade à '.fake()->city(),
            'description' => fake()->text(400),
            'user_id' => 1,
            'start_at' => fake()->date('Y-m-d', '2099-12-31'),
            'coordinates_start' => '4.118301338306185',
            'distance' => '200',
            'duration' => '120',
            'level' => random_int(1, 3),
            'max_participants' => random_int(2, 99)
        ];
    }
}
