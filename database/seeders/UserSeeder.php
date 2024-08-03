<?php

namespace Database\Seeders;

use App\Enums\AccountDesignation;
use App\Enums\UserType;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->createMany([
            /*[
                'name' => 'Xeuix',
                'designation' => AccountDesignation::SUPER_ADMIN,
                'email' => 'admin@xeuix.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ],*/
            [
                'client_id' => Client::inRandomOrder()->first()->id,
                'name' => 'Jasoda Health Care',
                'email' => 'jasodahealthcare@gmail.com',
                'phone_number' => '9439163363',
                'designation' => AccountDesignation::ADMIN,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]]);

        //User::factory(50)->create();
    }
}
