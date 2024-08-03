<?php

namespace Database\Seeders;

use App\Models\Client;
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
                'client_id' => Client::inRandomOrder()->first()->id,
                'name' => 'CBC',
                'amount' => rand(100,999),
            ],
            [
                'client_id' => Client::inRandomOrder()->first()->id,
                'name' => 'MRI',
                'amount' => rand(3000,9999),
            ],
            [
                'client_id' => Client::inRandomOrder()->first()->id,
                'name' => 'Blood Sugar',
                'amount' => rand(100,500),
            ],
            [
                'client_id' => Client::inRandomOrder()->first()->id,
                'name' => 'Culture',
                'amount' => rand(100,500),
            ],
            [
                'client_id' => Client::inRandomOrder()->first()->id,
                'name' => 'Endoscopy',
                'amount' => rand(2500,5000),
            ],
        ]);

        //ClinicalTest::factory(50)->create();
    }
}
