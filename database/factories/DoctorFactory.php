<?php

namespace Database\Factories;

use App\Enums\DaysOfWeek;
use App\Enums\DoctorType;
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
            'doctor_type' => $this->faker->randomElement(DoctorType::class),
            'name' => fake()->name(),
            'phone_number' => fake()->phoneNumber(),
            'available_days' => [
                $this->faker->randomElement(DaysOfWeek::getValues()),
                $this->faker->randomElement(DaysOfWeek::getValues()),
                $this->faker->randomElement(DaysOfWeek::getValues())
            ],
        ];
    }
}
