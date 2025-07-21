<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\Admin\AdminProfileInterface;

class AdminProfileService
{
    public function __construct(protected AdminProfileInterface $adminProfileRepository)
    {
    }

    public function show($admin)
    {
        return $this->adminProfileRepository->show($admin);
    }

    public function update($admin, array $data)
    {
        try {
            // إزالة current_password من البيانات
            unset($data['current_password']);
            unset($data['password_confirmation']);

            // معالجة الصورة إذا تم رفعها
            if (isset($data['image']) && $data['image']->isValid()) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($admin->image) {
                    Storage::disk('public')->delete($admin->image);
                }

                // حفظ الصورة الجديدة
                $imagePath = $data['image']->store('admins', 'public');
                $data['image'] = $imagePath;
            }

            // معالجة كلمة المرور إذا تم تغييرها
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            return $this->adminProfileRepository->update($admin, $data);
        } catch (\Exception $e) {
            throw new \Exception('حدث خطأ أثناء تحديث البروفايل: ' . $e->getMessage());
        }
    }

    public function delete($admin)
    {
        try {
            // حذف الصورة إذا كانت موجودة
            if ($admin->image) {
                Storage::disk('public')->delete($admin->image);
            }

            return $this->adminProfileRepository->delete($admin);
        } catch (\Exception $e) {
            throw new \Exception('حدث خطأ أثناء حذف الحساب: ' . $e->getMessage());
        }
    }
}
