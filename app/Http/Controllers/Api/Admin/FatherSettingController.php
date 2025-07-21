<?php

namespace App\Http\Controllers\Api\Admin;


use App\Http\Controllers\Controller;
use App\Services\Father\FatherSettingService;
use App\Http\Requests\Admin\FatherUpdateRequest;
use App\Http\Resources\FatherResource;
use App\Models\Father;

class FatherSettingController extends Controller
{
    public function __construct(protected FatherSettingService $fatherSettingService)
    {
        $this->middleware('role:admin');
    }

    public function index() {
        $fathers = $this->fatherSettingService->all();
        return self::success('تم استرجاع الآباء بنجاح',FatherResource::collection($fathers));
    }

    public function show(Father $father) {
        return self::success('تم استرجاع بيانات الأب بنجاح',new FatherResource($father->load(['students','students.classroom'])));
    }
    public function update(FatherUpdateRequest $request,Father $father)
    {
        $father = $this->fatherSettingService->update($father, $request->validated());
        return self::success('تم تحديث بيانات الأب بنجاح', new FatherResource($father));
    }

    public function destroy(Father $father)
    {
        $father->delete();
        return self::success('تم حذف الأب بنجاح');
    }

    public function approve($id)
    {
        $father = $this->fatherSettingService->approve($id);
        return $father ? self::success('تم قبول الأب بنجاح', new FatherResource($father)) :
            self::error('الأب مقبول مسبقاً');
    }

    // public function managePermissions(Request $request, $id)
    // {
    //     $father = $this->fatherSettingService->managePermissions($id, $request->permissions ?? []);
    //     return self::success('تم تحديث صلاحيات الأب بنجاح', $father);
    // }
}
