<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Services\VerificationCodeService;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\ResTPasswordRequest;
use App\Http\Requests\Admin\CheckRestCodeRequest;
use App\Http\Requests\Admin\SendResetCodeRequest;

class AdminAuthController extends Controller
{
    protected $verificationCodeService;

    public function __construct(VerificationCodeService $verificationCodeService)
    {
        $this->verificationCodeService = $verificationCodeService;
    }

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->validated();
        $admin = Admin::where('email', $credentials['email'])->first();
        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return self::error('بيانات الدخول غير صحيحة', null, 401);
        }
        $admin->firebaseTokens()->updateOrCreate(
            ['token' => $credentials['device_token']],
            ['tokenable_id' => $admin->id, 'tokenable_type' => 'admin']
        );
        $token = $admin->createToken('admin-token', ['*'], now()->addDays(7))->plainTextToken;
        return self::success('تم تسجيل الدخول بنجاح', [
            'name' => $admin->name,
            'email' => $admin->email,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user('admin')->currentAccessToken()->delete();
        return self::success('تم تسجيل الخروج بنجاح', null);
    }

    public function sendResetCode(SendResetCodeRequest $request)
    {
        $this->verificationCodeService->sendResetCode($request->validated()['email'], 'admin');
        return self::success('تم إرسال كود إعادة تعيين كلمة المرور إلى بريدك الإلكتروني', null);
    }

    public function checkResetCode(CheckRestCodeRequest $request)
    {
        $data = $request->validated();
        $token = $this->verificationCodeService->checkResetCode($data['email'], 'admin', $data['code']);
        if (!$token) {
            return self::error('الكود غير صحيح أو منتهي الصلاحية', null, 422);
        }
        return self::success('الكود صحيح، يمكنك الآن إعادة تعيين كلمة المرور', ['token' => $token]);
    }

    public function resetPassword(ResTPasswordRequest $request)
    {
        $data = $request->validated();
        $result = $this->verificationCodeService->resetPassword($data['token'], $data['password']);
        if (!$result) {
            return self::error('حدث خطأ أثناء إعادة تعيين كلمة المرور', null, 422);
        }
        return self::success('تم إعادة تعيين كلمة المرور بنجاح', null);
    }
}
