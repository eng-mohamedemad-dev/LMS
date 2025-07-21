<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Services\Admin\AdminProfileService;
use App\Http\Resources\AdminProfileResource;
use App\Http\Requests\Admin\AdminProfileUpdateRequest;

class ProfileController extends Controller
{
    public function __construct(protected AdminProfileService $adminProfileService)
    {
        $this->middleware('auth:admin');
    }

    /**
     * عرض بروفايل المدير
     */
    public function show()
    {
        try {
            $admin = $this->adminProfileService->show(auth()->guard('admin')->user());
            return self::success('بيانات البروفايل', new AdminProfileResource($admin));
        } catch (\Exception $e) {
            return self::error('حدث خطأ أثناء جلب بيانات البروفايل: ' . $e->getMessage());
        }
    }

    /**
     * تحديث بروفايل المدير
     */
    public function update(AdminProfileUpdateRequest $request)
    {
            $admin = $this->adminProfileService->update(auth()->guard('admin')->user(), $request->validated());
            return $admin ?self::success('تم تحديث البروفايل بنجاح', new AdminProfileResource($admin)) : 
                self::error('كلمة المرور الحالية غير صحيحة');
    }

    /**
     * حذف حساب المدير
     */
    public function destroy()
    {
        try {
            $this->adminProfileService->delete(auth()->guard('admin')->user());
            return self::success('تم حذف الحساب بنجاح');
        } catch (\Exception $e) {
            return self::error('حدث خطأ أثناء حذف الحساب: ' . $e->getMessage());
        }
    }
}
