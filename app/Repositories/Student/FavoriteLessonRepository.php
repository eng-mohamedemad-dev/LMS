<?php

namespace App\Repositories\Student;

use App\Interfaces\Student\FavoriteLessonInterface;

class FavoriteLessonRepository implements FavoriteLessonInterface
{
    protected $student;

    public function __construct()
    {
        $this->student = auth('student')->user();
    }

    public function add($lessonId){
        if (!$this->student->favoriteLessons->contains($lessonId)) {
            $this->student->favoriteLessons()->attach($lessonId);
            return true;
        }
    }

    public function all()
    {
        return $this->student->favoriteLessons()->with(['subject', 'unit'])->latest()->get();
    }

    public function remove($lessonId)
    {
        if ($this->student->favoriteLessons->contains($lessonId)) {
            $this->student->favoriteLessons()->detach($lessonId);
            return true;
        }
        return false;
    }

    public function deleteAll()
    {
        return $this->student->favoriteLessons()->detach();
    }
}
