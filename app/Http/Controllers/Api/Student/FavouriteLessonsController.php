<?php

namespace App\Http\Controllers\Api\Student;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\AddLessonFavouriteRequest;
use App\Http\Resources\LessonResource;
use App\Services\Student\FavoriteLessonService;
use Illuminate\Http\Request;

class FavouriteLessonsController extends Controller
{
    public function __construct(protected FavoriteLessonService $service)
    {
    }

    public function index()
    {
        $favorites = $this->service->all();
        return  self::success('الدروس المفضلة',LessonResource::collection($favorites));
    }

    public function store(AddLessonFavouriteRequest $request)
    {
        $added = $this->service->add($request->safe()->lesson_id);
        return $added ? self::success('تمت الإضافة إلى المفضلة') :
        self::error('هذا الدرس موجود بالفعل في المفضلة');
    }

    public function destroy($lessonId)
    {
        $removed = $this->service->remove($lessonId);
        return $removed ? self::success('تمت الإزالة من المفضلة') :
        self::error('الدرس غير موجود في المفضلة');
    }

    public function deleteAll() {
        $removed = $this->service->destroy();
        return $removed ? self::success('تم حذف جميع الدروس من المفضلة') : self::error('لا توجد اسأله في المفضلة');
    }
}