<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FatherProfileResource extends JsonResource
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
            'phone' => $this->phone,
            'address' => $this->address,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'status' => $this->status,
            'children' => $this->students->map(function($student) {
                return [
                    'name' => $student->name,
                    'email' => $student->email,
                    'father_phone' => $student->father_phone,
                    'classroom' => $student->classroom?->name,
                    'classification' => $student->classification,
                ];
            }),
        ];
    }
}
