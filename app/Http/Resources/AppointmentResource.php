<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'appointment_id' => $this->when($this->appointment_id, $this->appointment_id),
            'doctor_id' => $this->when($this->doctor_id, $this->doctor_id),
            'patient_id' => $this->when($this->patient_id, $this->patient_id),
            'appointment_date' => $this->when($this->appointment_date, function () {
                return Carbon::parse($this->appointment_date)->format('Y-m-d');
            }),
            'doctor' => DoctorResource::make($this->whenLoaded('doctor')),
            'patient' => PatientResource::make($this->whenLoaded('patient')),
            'clinical_test' => ClinicalTestResource::collection($this->whenLoaded('clinicalTests')),
            'created_at' => $this->when($this->created_at, $this->created_at)
        ];
    }
}
