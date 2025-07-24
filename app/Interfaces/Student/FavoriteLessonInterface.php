<?php

namespace App\Interfaces\Student;

interface FavoriteLessonInterface
{
    public function add($lessonId);
    public function all();
    public function remove($lessonId);
    public function deleteAll();
}
