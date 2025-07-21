<?php

namespace App\Repositories\Student;

use App\Interfaces\Student\StudentSettingInterface;
use App\Models\Student;

class StudentSettingRepository implements StudentSettingInterface
{

    public function all() {
        return Student::with(['classroom','father'])->get();
    }
    public function update($student, array $data)
    {
        return tap($student, function ($student) use ($data) {
            return $student->update($data);
        });
    }

    public function approve($id)
    {
        $student = Student::findOrFail($id);
        if ($student->status === 'approved') {
            return false;
        }
        return tap($student, function ($student) {
           return $student->update(['status' => 'approved']);
        });
    }

}
