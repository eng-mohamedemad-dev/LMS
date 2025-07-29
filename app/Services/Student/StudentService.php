<?php

namespace App\Services\Student;

use App\Models\Father;
use App\Models\Classroom;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Student\StudentRepository;

class StudentService
{
    protected $studentRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function login(array $credentials)
    {
        $student = $this->studentRepository->login($credentials);
        if (!$student) {
            return [
                'success' => false,
                'message' => 'بيانات الدخول غير صحيحة',
                'status' => 401
            ];
        }
        $token = $student->createToken('student-token', ['*'], now()->addDays(7))->plainTextToken;
        return [
            'success' => true,
            'data' => [
                'name' => $student->name,
                'email' => $student->email,
                'token' => $token
            ]
        ];
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $father = Father::where('phone', $data['father_phone'])->first();
        $data['classroom_id'] = Classroom::where('name', $data['classroom'])->value('id');
        if ($father) {
            $data['father_id'] = $father->id;
        }
        $student = $this->studentRepository->register($data);
        $student->assignRole('student');
        return $student;
    }
}
