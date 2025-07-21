<?php

namespace App\Services;

use App\Interfaces\FileInterface;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Storage;

class FileService
{
    use UploadTrait;
    protected $fileRepository;

    public function __construct(FileInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function create($data)
    {
        if ($data->file) {
            $data['file_path'] = $this->upload("public","files",$data->file);
        }
        return $this->fileRepository->create($data->toArray());
    }

    public function delete($file)
    {
        if ($file && $file->file_path) {
             $this->deleteFile("public",$file->file_path);
        }
        return $this->fileRepository->delete($file);
    }
}
