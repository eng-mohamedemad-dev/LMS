<?php

namespace App\Services;

use App\Interfaces\SubjectInterface;

class SubjectService
{
    public function __construct(protected SubjectInterface $subjectRepository)
    {
    }

    public function all()
    {
        return $this->subjectRepository->all();
    }

    public function create(array $data)
    {
        return $this->subjectRepository->create($data);
    }

    public function update($subject, array $data)
    {
        return $this->subjectRepository->update($subject, $data);
    }
}
