<?php

namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;
use App\Rules\ValidLessonForTeacher;

class QuizStoreRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
        'quiz_title' => 'required|string|max:255',
        'classroom_id' => 'required|exists:classrooms,id',
        'duration' => 'required|integer|min:1',
        'end_date' => 'required|date|after_or_equal:today',
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
            'quiz_title.required' => 'عنوان الاختبار مطلوب.',
            'quiz_title.string' => 'عنوان الاختبار يجب أن يكون نصاً.',
            'quiz_title.max' => 'عنوان الاختبار يجب ألا يتجاوز 255 حرفاً.',
            'classroom_id.required' => 'معرف الصف مطلوب.',
            'classroom_id.exists' => 'الصف المحدد غير موجود.',
            'duration.required' => 'المدة مطلوبة.',
            'duration.integer' => 'المدة يجب أن تكون رقمية.',
            'duration.min' => 'المدة يجب أن تكون على الأقل 1 دقيقة.',
            'end_date.date' => 'تاريخ الانتهاء يجب أن يكون تاريخاً صالحاً.',
            'end_date.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون اليوم أو بعده.',
            'lesson_id.required' => 'معرف الدرس مطلوب.',
            'lesson_id.exists' => 'الدرس المحدد غير موجود.',
            'questions.required' => 'يجب إرسال الأسئلة.',
            'questions.array' => 'الأسئلة يجب أن تكون في مصفوفة.',
            'questions.*.question_text.required' => 'نص السؤال مطلوب.',
            'questions.*.mark.required' => 'العلامة مطلوبة لكل سؤال.',
            'questions.*.mark.numeric' => 'العلامة يجب أن تكون رقمية.',
            'questions.*.mark.min' => 'العلامة يجب أن تكون على الأقل 1.',
            'questions.*.options.required' => 'يجب إضافة خيارات للسؤال.',
            'questions.*.options.array' => 'الخيارات يجب أن تكون في مصفوفة.',
            'questions.*.options.min' => 'يجب أن تحتوي الخيارات على خيارين على الأقل.',
            'questions.*.options.max' => 'يجب ألا تحتوي الخيارات على أكثر من أربعة خيارات.',
            'questions.*.options.*.required' => 'كل خيار مطلوب.',
            'questions.*.correct_answer.required' => 'الإجابة الصحيحة مطلوبة.',
            'questions.*.correct_answer.string' => 'الإجابة الصحيحة يجب أن تكون نصاً.',
            'questions.*.correct_answer.in' => 'الإجابة الصحيحة يجب أن تكون من ضمن الخيارات.',
        ];
    }
    }

