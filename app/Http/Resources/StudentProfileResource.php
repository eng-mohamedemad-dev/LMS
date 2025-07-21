<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'father_phone' => $this->father_phone,
            'address' => $this->address,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'status' => $this->status,
            'father_phone' => $this->father_phone,
            'classroom' => $this->classroom?->name,
            'classification' => $this->classification,

        ];
    }
}
