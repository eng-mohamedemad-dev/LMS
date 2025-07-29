<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin;
use App\Models\Father;
use App\Models\Student;
use App\Models\Teacher;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class Emailverify
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$type): Response
    {
        $email = $request->email;
        $model = [
             'admin' => Admin::class,
            'teacher' => Teacher::class,
            'student' => Student::class,
            'father' => Father::class,
        ][$type];
        $user = $model::where('email',$email)->first();
        if (!$user) {
            return $this->error("المستخدم غير موجود",null);
        }
        $valid = DB::table("email_verification_codes")->where([
            ['email',$user->email],
            ['user_type',$type]
        ])->first();
        if (!$valid) {
            return $this->error("البريد الإلكتروني غير موثوق به",null);
        }
            if($valid->email_verify_at !== null) {
                return $next($request);
            }
            return $this->error("يرجى التحقق من البريد الإلكتروني",null);
    }
}
