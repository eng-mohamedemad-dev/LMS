<?php

namespace App\Services\Teacher;

use App\Repositories\Teacher\TeacherRepository;
use Illuminate\Support\Facades\Hash;

class TeacherService
{
    protected $teacherRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function login(array $credentials)
    {
        $teacher = $this->teacherRepository->login($credentials);
        if (!$teacher) {
            return [
                'success' => false,
                'message' => 'بيانات الدخول غير صحيحة',
                'status' => 401
            ];
        }
        $token = $teacher->createToken('teacher-token', ['*'], now()->addDays(7))->plainTextToken;
        return [
            'success' => true,
            'data' => [
                'name' => $teacher->name,
                'email' => $teacher->email,
                'token' => $token
            ]
        ];
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $teacher = $this->teacherRepository->register($data);
        $teacher->assignRole('teacher');
        return $teacher;
    }
}
