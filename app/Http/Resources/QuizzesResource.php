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
        $student = auth('student')->user();
        $return = [
            'quize_id' => $this->id,
            'title' => $this->title,
            'total_marks' => $this->questions->sum('mark'),
            'questions_count' => $this->questions->count(),
            'is_solved' => false,
        ];
        if ($student) {
            $result = $student->results()->where('quiz_id', $this->id)->first();
            $is_solved = $result ? $result->exists() : false;
            if ($is_solved) {
                $return['is_solved'] = true;
                $return['score'] = $result->score;
                $return['is_passed'] = $result->is_passed;
                return $return;
            }
            
        }
        return[
            'quize_id' => $this->id, // 
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

