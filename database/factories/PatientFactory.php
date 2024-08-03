<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::inRandomOrder()->first()->id,
            'name' => fake()->name(),
            'patient_id' => substr(str_shuffle(str_repeat('0123456789', 10)), 0, 5) . time(),
            'phone_number' => substr(str_shuffle(str_repeat('0123456789', 10)), 0, 10)
        ];
    }
}
