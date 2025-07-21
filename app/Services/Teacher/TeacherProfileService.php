<?php

namespace App\Services\Teacher;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\Teacher\TeacherProfileInterface;

class TeacherProfileService
{
    public function __construct(protected TeacherProfileInterface $teacherProfileRepository)
    {
    }

    public function show($teacher)
    {
        return $this->teacherProfileRepository->show($teacher);
    }

    public function update($teacher, array $data)
    {
            if (isset($data['image']) && $data['image']->isValid()) {
                if ($teacher->image) {
                    Storage::disk('public')->delete($teacher->image);
                }
                $imagePath = $data['image']->store('teachers', 'public');
                $data['image'] = $imagePath;
            }
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            return $this->teacherProfileRepository->update($teacher, $data);
    }

    public function delete($teacher)
    {
        try {
            // حذف الصورة إذا كانت موجودة
            if ($teacher->image) {
                Storage::disk('public')->delete($teacher->image);
            }

            return $this->teacherProfileRepository->delete($teacher);
        } catch (\Exception $e) {
            throw new \Exception('حدث خطأ أثناء حذف الحساب: ' . $e->getMessage());
        }
    }
}
