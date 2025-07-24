<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class QuizSubmitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'quiz_id' => 'required|exists:quizzes,id',
        'answers' => 'required|array',
        'answers.*.question_id' => 'required|exists:questions,id',
        'answers.*.answer' => 'required|string'
        ];
    }

public function messages()
{
    return [
        'quiz_id.required' => 'يجب اختيار الكويز.',
        'quiz_id.exists' => 'الكويز غير موجود.',
        'answers.required' => 'يجب إدخال إجابات.',
        'answers.array' => 'الإجابات يجب أن تكون في شكل مصفوفة.',
        'answers.*.question_id.required' => 'يجب اختيار رقم السؤال.',
        'answers.*.question_id.exists' => 'السؤال غير موجود.',
        'answers.*.answer.required' => 'الإجابة مطلوبة لكل سؤال.',
        'answers.*.answer.string' => 'الإجابة يجب أن تكون نصية.',
    ];
}

}
