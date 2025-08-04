<?php

namespace App\Repositories;

use App\Models\Quiz;
use App\Interfaces\QuizInterface;

class QuizRepository implements QuizInterface
{
    public function all()
    {
        return Quiz::whereIn('subject_id', auth('teacher')->user()->subject->pluck('id')->toArray())
            ->with(['questions', 'lesson','subject'])
            ->latest('created_at')
            ->get();
    }

    public function find($quiz)
    {
        return $quiz->load(['questions', 'lesson','subject']);
    }

    public function create(array $data)
    {
        $questions = $data['questions'] ;
        $quiz = Quiz::create([
            'title'=> $data['quiz_title'],
            'lesson_id'=> $data['lesson_id'],
            'subject_id'=> $data['subject_id'],
            'duration'=> $data['duration'],
            'end_date' => $data['end_date'] ?? null,
        ]);
        $quiz->questions()->createMany($questions);
        return $quiz;
    }

    public function update($quiz, array $data)
{
    // تحديث بيانات الكويز
    $quiz->update([
        'title' => $data['quiz_title'],
        'lesson_id' => $data['lesson_id'],
        'subject_id' => $data['subject_id'],
        'duration' => $data['duration'],
        'end_date' => $data['end_date'] ?? null,
    ]);

    $quiz->questions()->delete();
    $quiz->questions()->createMany($data['questions']);

    return $quiz;
}


    public function delete($quiz)
    {
        $subjectId = auth('teacher')->user()->subject->pluck('id')->toArray();
        if (!in_array($quiz->subject->id, $subjectId)) {
          return false;
        }
        $quiz->questions()->delete();
        return $quiz->delete();
    }
}
