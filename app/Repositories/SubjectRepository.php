<?php

namespace App\Repositories;

use App\Interfaces\SubjectInterface;
use App\Models\Subject;

class SubjectRepository implements SubjectInterface
{
    public function all()
    {
        return Subject::with('classroom')->get();
    }

    public function create(array $data)
    {
        return Subject::create($data);
    }

    public function update($subject, array $data)
    {
       return tap($subject, function ($subject) use ($data) {
           return $subject->update($data);
       });
    }
}
