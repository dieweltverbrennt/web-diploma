<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Seat;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seat>
 */
class SeatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'row_number' => $this->faker->numberBetween(1, 10), 
            'seat_number' => $this->faker->numberBetween(1, 12),
            'type' => 'standard',
            'is_free' => false,
            'price' => 0,
        ];
    }
}
