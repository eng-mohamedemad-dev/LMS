<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Unit;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;



class TeacherController extends Controller
{
    public function classrooms()
    {
        $teacher = auth('teacher')->user();
        $subjects = $teacher->subject()->with('classroom')->get();

        $classrooms = $subjects->map(function ($subject) {
            return [
                'classroom_id' => $subject->classroom_id,
                'classroom_name' => $subject->classroom->name,
            ];
        })->unique('classroom_id')->values()->toArray();

        return self::success('تم إرجاع الصفوف الدراسية بنجاح', $classrooms);
    }

    public function students()
    {
         $teacher = auth('teacher')->user();
        $subjects = $teacher->subject()->with('classroom.students')->get();

    $students = $subjects->map(function ($subject) {
        return $subject->classroom->students->map(function ($student) {
            return [
                'name' => $student->name,
                'email' => $student->email,
                'father_phone' => $student->father_phone,
                'classication' => $student->classification,
                'classroom' => $student->classroom->name,
                'joined_at' => Carbon::parse($student->created_at)->format('Y-m-d H:i:s'),
                'image' => $student->image ? asset('storage/' . $student->image) : null,
            ];
        });
    })->flatten(1)->unique('email')->values()->toArray();
    return self::success('تم إرجاع الطلاب بنجاح', [
        'students' => $students
    ]);
    }

    public function units()
    {
       $units = Unit::all();
            return self::success('تم إرجاع الوحدات بنجاح', [
                'units' => $units->map(function ($unit) {
                    return [
                        'id' => $unit->id,
                        'name' => $unit->title,
                    ];
                }),
            ]);
    }

    public function subjects()
    {
        $subjects = \App\Models\Subject::whereNull('teacher_id')
        ->select('name')
        ->distinct()
        ->pluck('name')
        ->toArray();
    return self::success("تم إرجاع المواد بنجاح", [
        'subjects' => $subjects
    ]);
    }

 public function lesson()
{
    $teacher = auth('teacher')->user();
    $subjects = $teacher->subject()->with(['lessons', 'classroom'])->get();
    $lesson = $subjects->flatMap(function ($subject) {
        return $subject->lessons->map(function ($lesson) use ($subject) {
            return [
                'id' => $lesson->id,
                'title' => $lesson->title,
                'description' => $lesson->description,
                'classroom' => $subject->classroom->name,
            ];
        });
    })->values()->toArray();

    return self::success('تم إرجاع الدرس بنجاح', [
        'lesson' => $lesson
    ]);
}

}
