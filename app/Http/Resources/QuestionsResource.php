<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'question_id' => $this->id,
        'question_text' => $this->question_text,
        'options' => $this->options, 
        'mark' => $this->mark
    ];
    }
}
