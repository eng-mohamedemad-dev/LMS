<?php

namespace App\Services;

use App\Interfaces\ClassroomInterface;

class ClassroomService
{

    public function __construct(protected ClassroomInterface $classroomRepository)
    {
    }

    public function all()
    {
        return $this->classroomRepository->all();
    }

    public function create(array $data)
    {
        return $this->classroomRepository->create($data);
    }

    public function update($Classroom, array $data)
    {
        return $this->classroomRepository->update($Classroom, $data);
    }

}
