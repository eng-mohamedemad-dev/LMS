<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Quiz;

class ValidQuizForUpdate implements ValidationRule
{
    protected $teacherId;

    public function __construct($teacherId)
    {
        $this->teacherId = $teacherId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $quiz = Quiz::with(['subject', 'lesson'])->find($value);

        if (!$quiz) {
            $fail('الاختبار غير موجود.');
            return;
        }

        if ($quiz->subject->teacher_id !== $this->teacherId) {
            $fail('هذا الاختبار لا يخص هذا المعلم.');
            return;
        }

        if ($quiz->lesson->subject_id !== $quiz->subject_id) {
            $fail('الدرس لا ينتمي لنفس مادة الاختبار.');
            return;
        }

        if ($quiz->lesson->classroom_id !== $quiz->classroom_id) {
            $fail('الصف المرتبط بالدرس لا يطابق الصف المرتبط بالاختبار.');
            return;
        }
    }
}
