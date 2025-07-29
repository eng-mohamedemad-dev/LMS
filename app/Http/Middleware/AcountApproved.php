<?php

namespace App\Http\Middleware;

use App\Models\Father;
use App\Models\Student;
use App\Models\Teacher;
use Closure;
use Illuminate\Http\Request;

class AcountApproved
{
    public function handle(Request $request, Closure $next,$type)
    {
        $user = $this->type($type,$request->email);
        if (!$user || $user->status !== 'approved') {
            return response()->json([
                'status' => false,
                'message' => 'لم يتم الموافقة على الحساب  بعد'
            ], 403);
        }
        return $next($request);
    }

    protected function type($type,$email) {
        $model = [
            'student' => Student::class,
            'teacher' => Teacher::class,
            'father' => Father::class,
        ][$type];
        return $model::where('email',$email)->first();
    }
}
