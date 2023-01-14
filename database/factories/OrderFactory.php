<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Type>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'store_id' => random_int(1, 2),
            'provider_id' => random_int(20, 29),
            'type' => 1,
            'date' => fake()->dateTimeBetween('-1 years', 'now'),
            'status' => true
        ];
    }
}
