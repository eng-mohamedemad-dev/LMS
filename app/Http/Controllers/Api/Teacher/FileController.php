<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\File;
use App\Services\FileService;
use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Http\Requests\Teacher\FileStoreRequest;

class FileController extends Controller
{

    public function __construct(protected FileService $fileService)
    {
        $this->authorizeResource(File::class,'file');
    }

    public function store(FileStoreRequest $request)
    {
        $data = $request->validated();
        $file = $this->fileService->create(fluent($data));
        return self::success('تم رفع الملف بنجاح', new FileResource($file), 201);
    }

    public function destroy(File $file)
    {
        $this->fileService->delete($file);
        return self::success('تم حذف الملف بنجاح', null);
    }
}
