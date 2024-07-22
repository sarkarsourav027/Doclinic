<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'patient_id' => $this->when($this->patient_id, $this->patient_id),
            'name' => $this->when($this->name, $this->name),
            'phone_number' => $this->when($this->phone_number, $this->phone_number),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'appointments' => AppointmentResource::collection($this->whenLoaded('appointments')),
        ];
    }
}
