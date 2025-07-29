<?php

namespace App\Repositories\Teacher;

use App\Models\Teacher;
use App\Interfaces\Teacher\TeacherInterface;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class TeacherRepository implements TeacherInterface
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
        $teacher = Teacher::where('email', $credentials['email'])->first();
        if (!$teacher || !Hash::check($credentials['password'], $teacher->password)) {
            return null;
        }
            $teacher->firebaseTokens()->updateOrCreate(
                ['token' => $credentials['device_token']],
                ['tokenable_id' => $teacher->id, 'tokenable_type' => 'teacher']
            );
        return $teacher;
    }

    public function register(array $data)
    {
       DB::beginTransaction();

    try {
        $teacher = Teacher::create($data);
        $subjects = Subject::where('name', $data['subject_name'])->get();
        foreach ($subjects as $subject) {
            $subject->update(['teacher_id' => $teacher->id]);
        }
        $teacher->firebaseTokens()->updateOrCreate(
            ['token' => $data['device_token']],
            ['tokenable_id' => $teacher->id, 'tokenable_type' => 'teacher']
        );
        DB::commit(); 
       return $teacher;
    } catch (\Exception $e) {
        DB::rollBack(); 
        return response()->json([
            'message' => 'حدث خطأ أثناء التسجيل: ' . $e->getMessage()
        ], 500);
    }
    }
}
