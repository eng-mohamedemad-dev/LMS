<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Interfaces\Student\StudentInterface;
use Illuminate\Support\Facades\Hash;

class StudentRepository implements StudentInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function login(array $credentials)
    {
        $student = Student::where('email', $credentials['email'])->first();
        if (!$student || !Hash::check($credentials['password'], $student->password)) {
            return null;
        }
        return $student;
    }

    public function register(array $data)
    {
        return Student::create($data);
    }
}
