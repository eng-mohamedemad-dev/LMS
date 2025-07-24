<?php

namespace App\Repositories\Student;

use Illuminate\Support\Facades\Storage;
use App\Interfaces\Student\StudentProfileInterface;
use Illuminate\Support\Facades\Hash;

class StudentProfileRepository implements StudentProfileInterface
{
    public function show($student)
    {
        return $student->load(['father', 'classroom']);
    }

    public function update($student, array $data)
    {
        if (isset($data['current_password'])) {
        if (!Hash::check($data['current_password'], $student->password)) {
            return false;
        } 
        }
        return tap($student, function ($student) use ($data) {
            $student->update($data);
        });
    }

    public function delete($student)
    {
        if ($student->image && Storage::disk('public')->exists($student->image)) {
            Storage::disk('public')->delete($student->image);
        }
        return $student->delete();
    }
}
