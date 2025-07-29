<?php

namespace App\Interfaces;

interface LessonInterface
{
    public function all();
    public function create(array $data);
    public function update($id, array $data);
    public function delete($lesson);
}
