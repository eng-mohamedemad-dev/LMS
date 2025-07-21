<?php

namespace App\Services\Father;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Father\FatherRepository;

class FatherService
{
    protected $fatherRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(FatherRepository $fatherRepository)
    {
        $this->fatherRepository = $fatherRepository;
    }

    public function login(array $credentials)
    {
        $father = $this->fatherRepository->login($credentials);
        if (!$father) {
            return [
                'success' => false,
                'message' => 'بيانات الدخول غير صحيحة',
                'status' => 401
            ];
        }
        $token = $father->createToken('father-token', ['*'], now()->addDays(7))->plainTextToken;
        return [
            'success' => true,
            'data' => [
                'name' => $father->name,
                'email' => $father->email,
                'token' => $token
            ]
        ];
    }

    public function register(array $data)
    {
        // تحقق من وجود الهاتف أو الإيميل مسبقاً عبر الريبوستوري
        if ($this->fatherRepository->checkExistsByPhoneOrEmail($data['phone'], $data['email'])) {
            return [
                'success' => false,
                'message' => 'رقم الهاتف أو البريد الإلكتروني مستخدم بالفعل',
                'status' => 422
            ];
        }
        $data['password'] = Hash::make($data['password']);
        $father = $this->fatherRepository->register($data);
        $father->assignRole('father');
        Student::where('father_phone', $father->phone)->update(['father_id' => $father->id]);
        return [
            'success' => true,
            'data' => $father
        ];
    }
}
