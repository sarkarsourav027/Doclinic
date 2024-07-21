<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'doctor_type' => $this->when($this->doctor_type, $this->doctor_type),
            'name' => $this->when($this->name, $this->name),
            'phone_number' => $this->when($this->phone_number, $this->phone_number),
            'available_days' => $this->when($this->available_days, $this->available_days),
            'avatar' => $this->when($this->avatar, $this->avatar),
            'created_at' => $this->when($this->created_at, $this->created_at)
        ];
    }
}
