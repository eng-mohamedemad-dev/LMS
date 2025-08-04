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
            'duration' => $this->duration,
            'total_marks' => $this->questions->sum('mark'),
            'questions_count' => $this->questions->count(),
            'end_date' => $this->end_date,
        ];
        if ($student) {
            $result = $student->results()->where('quiz_id', $this->id)->first();
            $is_solved = $result->exists();
            if ($is_solved) {
                $return['is_solved'] = true;
                $return['score'] = $result->score;
                $return['is_passed'] = $result->is_passed;
            }
            $return['is_solved'] = $is_solved;
            return $return;
            
        }
        return[
            'quize_id' => $this->id, // 
            'title' => $this->title,
            'duration' => $this->duration,
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

