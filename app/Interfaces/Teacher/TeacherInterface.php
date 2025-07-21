<?php

namespace App\Interfaces\Teacher;

interface TeacherInterface
{
    public function login(array $credentials);
    public function register(array $data);
}
