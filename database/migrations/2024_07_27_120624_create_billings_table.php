<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->foreignId('appointment_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('billing_date');
            $table->decimal('doctor_fees',18,2);
            $table->decimal('clinical_test_amount',18,2);
            $table->decimal('billing_amount',18,2);
            $table->enum('payment_mode', ['cash', 'online']);
            $table->boolean('is_gst_bill')->default(false);
            $table->decimal('gst_percentage',18,2);
            $table->string('invoice_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
