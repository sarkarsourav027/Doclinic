<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\ClinicalTest;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::factory(50)->create()->each(function ($appointment) {
            // Attach a random number of clinical tests to each appointment
            $appointment->clinicalTests()->attach(
                ClinicalTest::inRandomOrder()->first()->id
            );
        });
    }
}
