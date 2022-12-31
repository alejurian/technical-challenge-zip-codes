<?php

namespace Database\Factories;

use App\Models\FederalEntity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FederalEntity>
 */
class FederalEntityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => strtoupper(fake()->state()),
        ];
    }
}
