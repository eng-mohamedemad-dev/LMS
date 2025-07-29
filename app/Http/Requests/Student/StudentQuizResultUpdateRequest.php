<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\BaseRequest;

class StudentQuizResultUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'score' => 'sometimes|required|numeric|min:0',
            'submitted_at' => 'sometimes|required|date',
        ];
    }
}
