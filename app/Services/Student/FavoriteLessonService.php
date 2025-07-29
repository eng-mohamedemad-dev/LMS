<?php

namespace App\Services\Student;

use App\Interfaces\Student\FavoriteLessonInterface;

class FavoriteLessonService
{
    public function __construct(protected FavoriteLessonInterface $repo)
    {
    }

    public function add($lessonId)
    {
        return $this->repo->add($lessonId);
    }

    public function all()
    {
        return $this->repo->all();
    }

    public function remove($lessonId)
    {
        return $this->repo->remove($lessonId);
    }

    public function destroy()
    {
        return $this->repo->deleteAll();
    }
}
