<?php

namespace App\Repositories;

use App\Models\Classroom;
use App\Interfaces\ClassroomInterface;

class ClassroomRepository implements ClassroomInterface
{
    public function all()
    {
        return Classroom::with(['students', 'subjects'])->get();
    }

    public function create(array $data)
    {
        return Classroom::create($data);
    }

    public function update($classroom, array $data)
    {
        return tap($classroom,function($classroom) use ($data) {
            return $classroom->update($data);
        });
    }

}
