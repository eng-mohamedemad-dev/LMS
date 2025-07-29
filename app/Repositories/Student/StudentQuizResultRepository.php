<?php

namespace App\Repositories\Student;

use App\Interfaces\StudentQuizResultInterface;
use App\Models\StudentQuizResult;

class StudentQuizResultRepository implements StudentQuizResultInterface
{
    public function all()
    {
        return StudentQuizResult::all();
    }

    public function find($id)
    {
        return StudentQuizResult::findOrFail($id);
    }

    public function create(array $data)
    {
        return StudentQuizResult::create($data);
    }

    public function update($id, array $data)
    {
        $result = StudentQuizResult::findOrFail($id);
        $result->update($data);
        return $result;
    }

    public function delete($id)
    {
        $result = StudentQuizResult::findOrFail($id);
        return $result->delete();
    }
}
