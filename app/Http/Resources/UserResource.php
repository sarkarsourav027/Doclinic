<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'client_id' => $this->when($this->client_id, $this->client_id),
            'designation' => $this->when($this->designation, $this->designation),
            'name' => $this->when($this->name, $this->name),
            'email' => $this->when($this->email, $this->email),
            'phone_number' => $this->when($this->phone_number, $this->phone_number),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'parent' => UserResource::make($this->whenLoaded('parent')),
        ];
    }
}
