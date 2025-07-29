<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Lesson;

class ValidLessonForTeacher implements Rule
{
    protected $teacherId;
    protected $classroomId;

    public function __construct($teacherId, $classroomId)
    {
        $this->teacherId = $teacherId;
        $this->classroomId = $classroomId;
    }

    public function passes($attribute, $value): bool
    {
        $lesson = Lesson::with('subject')->find($value);

        if (!$lesson || !$lesson->subject) {
            return false;
        }

        return
            $lesson->subject->teacher_id === $this->teacherId &&
            $lesson->subject->classroom_id === $this->classroomId;
    }

    public function message(): string
    {
        return 'الدرس لا يتبع الفصل أو المدرس الحالي.';
    }
}
