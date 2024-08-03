<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::factory()->create([
            'name' => 'Jasoda Health Care',
            'email' => 'jasodahealthcare@gmail.com',
            'phone_number' => '9439163363',
            'address' => 'PLOT NO-1215/1535,KHANDAGIRI BARI, BHUABNESWAR, 751030',
            'gst_number' => '21EYEPS1004LIZN',
        ]);

        //Client::factory(5)->create();
    }
}
