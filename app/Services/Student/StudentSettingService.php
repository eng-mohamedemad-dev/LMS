<?php

namespace App\Services\Student;

use App\Interfaces\Student\StudentSettingInterface;

class StudentSettingService
{
    public function __construct(protected StudentSettingInterface $studentSettingRepository)
    {

    }

    public function all() {
        return $this->studentSettingRepository->all();
    }

    public function update($student, array $data)
    {
        return $this->studentSettingRepository->update($student, $data);
    }

    public function approve($id)
    {
        return $this->studentSettingRepository->approve($id);
    }
}
