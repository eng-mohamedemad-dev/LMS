<?php

namespace App\Services\Teacher;

use App\Interfaces\Teacher\TeacherSettingInterface;

class TeacherSettingService
{
    public function __construct(protected TeacherSettingInterface $teacherSettingRepository)
    {
    }

    public function all()
    {
        return $this->teacherSettingRepository->all();
    }

    public function update($teacher, array $data)
    {
        return $this->teacherSettingRepository->update($teacher, $data);
    }

    public function approve($id)
    {
        return $this->teacherSettingRepository->approve($id);
    }

}
