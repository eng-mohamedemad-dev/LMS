<?php

namespace App\Interfaces\Student;

interface StudentInterface
{
    public function login(array $credentials);
    public function register(array $data);
}
