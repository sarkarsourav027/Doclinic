<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (config('app.env') === 'local'){
            $this->call(UserSeeder::class);
            $this->call(ClinicalTestSeeder::class);
            $this->call(DoctorSeeder::class);
            $this->call(PatientSeeder::class);
            $this->call(AppointmentSeeder::class);
            $this->call(BillingSeeder::class);
            $this->call(InvoiceSeeder::class);
        }
    }
}
