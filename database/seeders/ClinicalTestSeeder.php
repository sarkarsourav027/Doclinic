<?php

namespace Database\Seeders;

use App\Models\ClinicalTest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClinicalTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClinicalTest::factory()->createMany([
            [
                'name' => 'CBC',
                'amount' => rand(100,999),
            ],
            [
                'name' => 'MRI',
                'amount' => rand(3000,9999),
            ],
            [
                'name' => 'Blood Sugar',
                'amount' => rand(100,500),
            ],
            [
                'name' => 'Culture',
                'amount' => rand(100,500),
            ],
            [
                'name' => 'Endoscopy',
                'amount' => rand(2500,5000),
            ],
        ]);

        //ClinicalTest::factory(50)->create();
    }
}
