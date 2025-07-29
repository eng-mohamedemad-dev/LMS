<?php

namespace App\Repositories\Teacher;

use App\Models\Teacher;
use App\Interfaces\Teacher\TeacherSettingInterface;

class TeacherSettingRepository implements TeacherSettingInterface
{
    public function all()
    {
        return Teacher::with('subject')->get();
    }
    public function update($teacher, array $data)
    {
        return tap($teacher, function ($teacher) use ($data) {
            return $teacher->update($data);
        });
    }

    public function approve($id)
    {
        $teacher = Teacher::findOrFail($id);
        if ($teacher->status === 'approved') {
            return false;
        }
        return tap($teacher, function ($teacher) {
            $teacher->update(['status' => 'approved']);
        });
    }

}
