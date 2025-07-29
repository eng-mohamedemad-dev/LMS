<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Services\VideoService;
use App\Http\Requests\Teacher\VideoStoreRequest;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{

    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function index()
    {
        $videos = $this->videoService->all();
        return self::success('قائمة الفيديوهات', $videos);
    }

    public function show($id)
    {
        $video = $this->videoService->find($id);
        return self::success('تفاصيل الفيديو', $video);
    }

    public function store(VideoStoreRequest $request)
    {
        $data = $request->validated();
        $uploadedVideo = $request->file('video');
        $path = $uploadedVideo->store('uploads/videos', 'public');
        $data['path'] = $path;
        $data['original_name'] = $uploadedVideo->getClientOriginalName();
        $video = $this->videoService->create($data);
        return self::success('تم رفع الفيديو بنجاح', $video, 201);
    }

    public function destroy($id)
    {
        $video = $this->videoService->find($id);
        if ($video && $video->path) {
            Storage::disk('public')->delete($video->path);
        }
        $this->videoService->delete($id);
        return self::success('تم حذف الفيديو بنجاح', null);
    }
}
