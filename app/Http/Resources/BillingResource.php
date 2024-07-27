<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BillingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->when($this->id, $this->id),
            'invoice_number' => $this->when($this->invoice_number, $this->invoice_number),
            'invoice_file' => $this->when($this->invoice_file, Storage::url('invoice/' . $this->invoice_file)),
            'appointment_id' => $this->when($this->appointment_id, $this->appointment_id),
            'doctor_fees' => $this->when($this->doctor_fees, $this->doctor_fees),
            'clinical_test_amount' => $this->when($this->clinical_test_amount, $this->clinical_test_amount),
            'billing_amount' => $this->when($this->billing_amount, $this->billing_amount),
            'payment_mode' => $this->when($this->payment_mode, $this->payment_mode),
            'is_gst_bill' => $this->when($this->is_gst_bill, $this->is_gst_bill),
            'gst_percentage' => $this->when($this->gst_percentage, $this->gst_percentage),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'appointment' => AppointmentResource::make($this->whenLoaded('appointment')),
        ];
    }
}
