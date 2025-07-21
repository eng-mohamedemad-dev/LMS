<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentQuizResult;
use App\Models\Student;

class TeacherStudentResultController extends Controller
{
    public function index()
    {
        $teacher = Auth::guard('teacher')->user();
        // جلب المادة الخاصة بالمعلم
        $subject = $teacher->subject;
        if (!$subject) {
            return self::error('لا يوجد مادة مرتبطة بهذا المعلم', null, 404);
        }
        // جلب الطلاب المرتبطين بنفس الفصل الخاص بالمادة
        $students = Student::where('classroom_id', $subject->classroom_id)->pluck('id');
        $results = StudentQuizResult::whereIn('student_id', $students)->with(['student', 'quiz'])->get();
        return self::success('نتائج الطلاب', $results);
    }
}
