<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class InvoiceResource extends JsonResource
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
            'clinical_test_amount' => $this->when($this->clinical_test_amount, $this->clinical_test_amount),
            'invoice_amount' => $this->when($this->invoice_amount, $this->invoice_amount),
            'payment_mode' => $this->when($this->payment_mode, $this->payment_mode),
            'is_gst_bill' => $this->when($this->is_gst_bill, $this->is_gst_bill),
            'gst_percentage' => $this->when($this->gst_percentage, $this->gst_percentage),
            'created_at' => $this->when($this->created_at, $this->created_at),
            //'clinicalTests' => ClinicalTestResource::collection($this->whenLoaded('clinicalTests')),
        ];
    }
}
