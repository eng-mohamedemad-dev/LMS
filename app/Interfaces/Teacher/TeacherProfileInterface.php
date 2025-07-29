<?php

namespace App\Interfaces\Teacher;

interface TeacherProfileInterface
{
    public function show($teacher);

    public function update($teacher, array $data);

    public function delete($teacher);
}
