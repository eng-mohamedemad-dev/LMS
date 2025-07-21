<?php

namespace App\Services;

use App\Interfaces\StudentQuizResultInterface;
use App\Repositories\Student\StudentQuizResultRepository;

class StudentQuizResultService
{
    protected $resultRepository;

    public function __construct(StudentQuizResultInterface $resultRepository)
    {
        $this->resultRepository = $resultRepository;
    }

    public function all()
    {
        return $this->resultRepository->all();
    }

    public function find($id)
    {
        return $this->resultRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->resultRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->resultRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->resultRepository->delete($id);
    }
}
