<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
  public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'name' => $this->name,
        'image' => $this->image ? asset('language/' . $this->image) : null,
        'classroom' => $this->classroom?->name,
        'teacher' => $this->teacher?->name,
    ];
}
}

