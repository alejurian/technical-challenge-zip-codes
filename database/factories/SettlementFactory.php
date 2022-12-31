<?php

namespace Database\Factories;

use App\Models\Settlement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Settlement>
 */
class SettlementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => fake()->numberBetween(100, 3000),
            'name' => strtoupper(fake()->city()),
            'zone_type' => ['URBANO', 'RURAL'][fake()->numberBetween(0, 1)],
        ];
    }
}
