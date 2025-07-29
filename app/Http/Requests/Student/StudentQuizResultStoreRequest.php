<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\BaseRequest;

class StudentQuizResultStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quiz_id' => 'required|exists:quizzes,id',
            'score' => 'required|numeric|min:0',
            'submitted_at' => 'required|date',
        ];
    }
}
