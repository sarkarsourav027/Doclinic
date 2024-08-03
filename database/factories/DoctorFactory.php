<?php

namespace Database\Factories;

use App\Enums\DaysOfWeek;
use App\Enums\DoctorType;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
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
            'doctor_type' => $this->faker->randomElement(DoctorType::class),
            'name' => fake()->name(),
            'phone_number' => substr(str_shuffle(str_repeat('0123456789', 10)), 0, 10),
            'fees' => $this->faker->randomElement([500,700,800,1000]),
            'available_days' => [
                $this->faker->randomElement(DaysOfWeek::getValues()),
                $this->faker->randomElement(DaysOfWeek::getValues()),
                $this->faker->randomElement(DaysOfWeek::getValues())
            ],
        ];
    }
}
