<?php

namespace Database\Seeders;

use App\Models\ClinicalTest;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Invoice::factory(50)->create();
        /*Invoice::factory(50)->create()->each(function ($invoice) {
            // Attach a random number of clinical tests to each appointment
            $invoice->clinicalTests()->attach(ClinicalTest::inRandomOrder()->first()->id, [
                'clinical_test_amount' => rand(500, 7000)
            ]);
        });*/
    }
}
