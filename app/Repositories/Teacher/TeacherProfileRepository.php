<?php

namespace App\Repositories\Teacher;

use App\Models\Lesson;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\Teacher\TeacherProfileInterface;

class TeacherProfileRepository implements TeacherProfileInterface
{
    public function show($teacher)
    {
       return $teacher->load([
    'subject.classroom.students', 
    'subject.lessons',            
]);

    }

    public function update($teacher, array $data)
    {
        if (isset($data['current_password'])) {
        if (!Hash::check($data['current_password'], $teacher->password)) {
            return false;
        } 
        }
        return tap($teacher, function ($teacher) use ($data) {
            $teacher->update($data);
        });
    }

    public function delete($teacher)
    {
        if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
            Storage::disk('public')->delete($teacher->image);
        }
        Lesson::whereIn('subject_id', $teacher->subject->pluck('id'))->delete();
        return $teacher->delete();
    }
}
