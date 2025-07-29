<?php

namespace App\Services;

use App\Interfaces\QuizInterface;

class QuizService
{
    public function __construct(protected QuizInterface $quizRepository)
    {
    }

    public function all()
    {
        return $this->quizRepository->all();
    }

    public function find($quiz)
    {
         $subjectId = auth('teacher')->user()->subject->pluck('id')->toArray();
        if (!in_array($quiz->subject->id, $subjectId)) {
          return false;
        }
        return $this->quizRepository->find($quiz);
    }

    public function create(array $data)
    {
        return $this->quizRepository->create($data);
    }

    public function update($quiz, array $data)
    {
        return $this->quizRepository->update($quiz, $data);
    }

    public function delete($quiz)
    {
        return $this->quizRepository->delete($quiz);
    }
}
