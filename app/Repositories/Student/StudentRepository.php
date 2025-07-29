<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Interfaces\Student\StudentInterface;
use Illuminate\Support\Facades\Hash;

class StudentRepository implements StudentInterface
{
    public function login(array $credentials)
    {
        $student = Student::where('email', $credentials['email'])->first();
        if (!$student || !Hash::check($credentials['password'], $student->password)) {
            return null;
        }
        $student->firebaseTokens()->updateOrCreate(
            ['token' => $credentials['device_token']],
            ['tokenable_id' => $student->id, 'tokenable_type' => 'student']
        );
        return $student;
    }

    public function register(array $data)
    {
        $student = Student::create($data);
        $student->firebaseTokens()->updateOrCreate(
            ['token' => $data['device_token']],
            ['tokenable_id' => $student->id, 'tokenable_type' => 'student']
        );
        return $student;
    }
}
