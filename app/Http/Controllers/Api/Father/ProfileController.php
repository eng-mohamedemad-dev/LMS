<?php

namespace App\Http\Controllers\Api\Father;

use App\Models\Father;
use App\Http\Controllers\Controller;
use App\Http\Resources\FatherProfileResource;
use App\Services\Father\FatherProfileService;
use App\Http\Requests\Father\FatherProfileUpdateRequest;

class ProfileController extends Controller
{
    public function __construct(protected FatherProfileService $fatherProfileService)
    {
        $this->middleware('auth:father');
    }

    /**
     * عرض بروفايل ولي الأمر
     */
    public function show()
    {
      
            $father = $this->fatherProfileService->show(auth()->guard('father')->user());
            return $father ? self::success('بيانات البروفايل', new FatherProfileResource($father)) : 
                self::error('كلمة المرور الحالية غير صحيحة');
               
        
    }

    /**
     * تحديث بروفايل ولي الأمر
     */
    public function update(FatherProfileUpdateRequest $request)
    {
        try {
            $father = $this->fatherProfileService->update(auth()->guard('father')->user(), $request->validated());
            return self::success('تم تحديث البروفايل بنجاح', new FatherProfileResource($father));
        } catch (\Exception $e) {
            return self::error('حدث خطأ أثناء تحديث البروفايل: ' . $e->getMessage());
        }
    }

    /**
     * حذف حساب ولي الأمر
     */
    public function destroy()
    {
        try {
            $this->fatherProfileService->delete(auth()->guard('father')->user());
            return self::success('تم حذف الحساب بنجاح');
        } catch (\Exception $e) {
            return self::error('حدث خطأ أثناء حذف الحساب: ' . $e->getMessage());
        }
    }
}
