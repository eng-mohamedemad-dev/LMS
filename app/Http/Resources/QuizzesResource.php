<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizzesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'title' => $this->title,
            'lesson' => $this->lesson->title,
            'classroom' => $this->lesson->subject->classroom->name,
            'total_marks' => $this->questions->sum('mark'),
            'questions' => $this->questions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'text' => $question->question_text,
                    'mark' => $question->mark,
                    'options' => $question->options,
                    'correct_answer' => $question->correct_answer,
                ];
            }),

        ];
    }
}
