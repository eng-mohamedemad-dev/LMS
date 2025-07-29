<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id" =>$this->id,
            "name" => $this->name,
            "phone" => $this->phone,
            "email" => $this->email,
            "boys" => [
                collect($this->students)->map(function($student) {
                return [
                    "id" => $this->id,
                    "name" => $student->name,
                    "email" => $student->email,
                    "father_phone" => $student->father_phone,
                    "classroom" => $student->classroom->name
                ];
                })
            ]
        ];
    }
}
