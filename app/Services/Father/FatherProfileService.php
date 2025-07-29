<?php

namespace App\Services\Father;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\Father\FatherProfileInterface;

class FatherProfileService
{
    public function __construct(protected FatherProfileInterface $fatherProfileRepository)
    {
    }

    public function show($father)
    {
        return $this->fatherProfileRepository->show($father);
    }

    public function update($father, array $data)
    {
        try {
            // إزالة current_password من البيانات
            unset($data['current_password']);
            unset($data['password_confirmation']);

            // معالجة الصورة إذا تم رفعها
            if (isset($data['image']) && $data['image']->isValid()) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($father->image) {
                    Storage::disk('public')->delete($father->image);
                }

                // حفظ الصورة الجديدة
                $imagePath = $data['image']->store('fathers', 'public');
                $data['image'] = $imagePath;
            }

            // معالجة كلمة المرور إذا تم تغييرها
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            return $this->fatherProfileRepository->update($father, $data);
        } catch (\Exception $e) {
            throw new \Exception('حدث خطأ أثناء تحديث البروفايل: ' . $e->getMessage());
        }
    }

    public function delete($father)
    {
        try {
            // حذف الصورة إذا كانت موجودة
            if ($father->image) {
                Storage::disk('public')->delete($father->image);
            }

            return $this->fatherProfileRepository->delete($father);
        } catch (\Exception $e) {
            throw new \Exception('حدث خطأ أثناء حذف الحساب: ' . $e->getMessage());
        }
    }
}
