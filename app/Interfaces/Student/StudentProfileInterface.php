<?php

namespace App\Interfaces\Student;

interface StudentProfileInterface
{
    public function show($student);

    public function update($student, array $data);

    public function delete($student);
}
