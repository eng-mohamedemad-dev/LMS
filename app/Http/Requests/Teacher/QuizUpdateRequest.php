<?php

namespace App\Http\Requests\Teacher;

use App\Rules\ValidQuizForUpdate;
use App\Http\Requests\BaseRequest;
use App\Rules\ValidLessonForTeacher;

class QuizUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
    return [
        'quiz_id' => [
            'required',
            'exists:quizzes,id',
            new ValidQuizForUpdate(auth('teacher')->id())
        ],
        'quiz_title' => 'sometimes|required|string|max:255',
        'classroom_id' => 'required|exists:classrooms,id',
        'duration' => 'sometimes|required|integer|min:1',
        'end_date' => 'nullable|date|after_or_equal:today',
        'lesson_id' => [
            'required',
            'exists:lessons,id',
            new ValidLessonForTeacher(auth('teacher')->id(), $this->classroom_id)
        ],
        'questions' => 'required|array|min:1',
        'questions.*.question_text' => 'required|string',
        'questions.*.mark' => 'sometimes|required|numeric|min:1',
        'questions.*.options' => 'required|array|min:2|max:4',
        'questions.*.options.*' => 'required|string',
        'questions.*.correct_answer' => [
            'required',
            'string',
            function ($attribute, $value, $fail) {
                $index = explode('.', $attribute)[1];
                $options = $this->input("questions.$index.options", []);
                if (!in_array($value, $options)) {
                    $fail("الإجابة الصحيحة يجب أن تكون من ضمن الخيارات الخاصة بالسؤال رقم " . ($index + 1));
                }
            }
        ],
    ];
}

    public function messages(): array
    {
        return [
            'quiz_id.required' => 'معرف الاختبار مطلوب.',
            'quiz_id.exists' => 'الاختبار المحدد غير موجود.',
            'classroom_id.required' => 'معرف الفصل الدراسي مطلوب.',
            'classroom_id.exists' => 'الفصل الدراسي المحدد غير موجود.',
            'duration.required' => 'المدة مطلوبة.',
            'duration.integer' => 'المدة يجب أن تكون رقمية.',
            'duration.min' => 'المدة يجب أن تكون على الأقل 1 دقيقة.',
            'end_date.date' => 'تاريخ الانتهاء يجب أن يكون تاريخاً صالحاً.',
            'end_date.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون اليوم أو بعده.',
            'lesson_id.required' => 'معرف الدرس مطلوب.',
            'lesson_id.exists' => 'الدرس المحدد غير موجود.',
            'quiz_title.required' => 'عنوان الاختبار مطلوب.',
            'quiz_title.string' => 'عنوان الاختبار يجب أن يكون نصاً.',
            'quiz_title.max' => 'عنوان الاختبار يجب ألا يتجاوز 255 حرفاً.',
            'questions.required' => 'يجب إضافة أسئلة للاختبار.',
            'questions.*.question_text.required' => 'نص السؤال مطلوب.',
            'questions.*.mark.required' => 'العلامة مطلوبة لكل سؤال.',
            'questions.*.mark.numeric' => 'العلامة يجب أن تكون رقمية.',
            'questions.*.mark.min' => 'العلامة يجب أن تكون على الأقل 1.',
            'questions.*.options.required' => 'يجب إضافة خيارات للسؤال.',
            'questions.*.correct_answer.required' => 'الإجابة الصحيحة مطلوبة.',
        ];
    }
}

