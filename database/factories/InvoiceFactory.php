<?php

namespace Database\Factories;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clinical_test_amount = rand(999,99999);
        $is_gst_bill = $this->faker->randomElement([0,1]);
        return [
            'client_id' => Client::inRandomOrder()->first()->id,
            'invoice_number' => 'INV' . substr(str_shuffle(str_repeat('0123456789', 10)), 0, 5) . time(),
            'invoice_date' => Carbon::now()->addDays(rand(0, 5))->format('Y-m-d'),
            'clinical_test_amount' => $clinical_test_amount,
            'invoice_amount' => $clinical_test_amount,
            'payment_mode' => $this->faker->randomElement(['cash','online']),
            'is_gst_bill' => $is_gst_bill,
            'gst_percentage' => $is_gst_bill ? $this->faker->randomElement([9,18]) : 0,
        ];
    }
}
