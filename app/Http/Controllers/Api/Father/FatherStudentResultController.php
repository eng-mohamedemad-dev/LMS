<?php

namespace App\Http\Controllers\Api\Father;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentQuizResult;

class FatherStudentResultController extends Controller
{

    public function index()
    {
        $father = Auth::guard('father')->user();
        $students = $father->students()->pluck('id');
        $results = StudentQuizResult::whereIn('student_id', $students)->with(['student', 'quiz'])->get();
        return self::success('نتائج الأبناء', $results);
    }
}
