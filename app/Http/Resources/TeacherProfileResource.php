<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   public function toArray(Request $request): array
{
    $subjects = $this->subject;

    $totalStudents = 0;
    $totalLessons = 0;

   $subjectData = $subjects->map(function ($subject) use (&$totalStudents, &$totalLessons) {
    $studentsCount = $subject->classroom?->students->count() ?? 0;
    $lessonsCount = $subject->lessons->count();

    $totalStudents += $studentsCount;
    $totalLessons += $lessonsCount;

    return [
        'name' => $subject->name,
        'classroom' => $subject->classroom?->name,
        'students_count' => $studentsCount,
        'lessons_count' => $lessonsCount,
    ];
});


    $data = [
        'name' => $this->name,
        'email' => $this->email,
        'phone' => $this->phone,
        'address' => $this->address,
        'image' => $this->image ? asset('storage/' . $this->image) : null,
        'status' => $this->status,
        'subjects' => $subjectData,
        'total_students' => $totalStudents,
        'total_lessons' => $totalLessons,
    ];

   
    if ($request->method() === 'PUT') {
        unset($data['status'], $data['subjects'], $data['total_students'], $data['total_lessons']);
    }

    return $data;
}

}
