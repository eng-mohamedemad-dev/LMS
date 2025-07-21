<?php

namespace App\Services\Student;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\Student\StudentProfileInterface;

class StudentProfileService
{
    public function __construct(protected StudentProfileInterface $studentProfileRepository)
    {
    }

    public function show($student)
    {
        return $this->studentProfileRepository->show($student);
    }

    public function update($student, array $data)
    {
        try {
            // إزالة current_password من البيانات
            unset($data['current_password']);
            unset($data['password_confirmation']);

            // معالجة الصورة إذا تم رفعها
            if (isset($data['image']) && $data['image']->isValid()) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($student->image) {
                    Storage::disk('public')->delete($student->image);
                }

                // حفظ الصورة الجديدة
                $imagePath = $data['image']->store('students', 'public');
                $data['image'] = $imagePath;
            }

            // معالجة كلمة المرور إذا تم تغييرها
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            return $this->studentProfileRepository->update($student, $data);
        } catch (\Exception $e) {
            throw new \Exception('حدث خطأ أثناء تحديث البروفايل: ' . $e->getMessage());
        }
    }

    public function delete($student)
    {
        try {
            // حذف الصورة إذا كانت موجودة
            if ($student->image) {
                Storage::disk('public')->delete($student->image);
            }

            return $this->studentProfileRepository->delete($student);
        } catch (\Exception $e) {
            throw new \Exception('حدث خطأ أثناء حذف الحساب: ' . $e->getMessage());
        }
    }
}
