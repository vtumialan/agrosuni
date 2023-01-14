<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Type>
 */
class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->company(),
            'document_id' => random_int(10000000000, 10999999999),
            'contact' => fake()->name(),
            'phone' => random_int(970005100, 999888999),
            'address' => fake()->streetAddress(),
            'email' => fake()->email(),
            'status' => true,
        ];
    }
}
