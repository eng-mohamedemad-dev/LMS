<?php

namespace App\Services;

use App\Interfaces\LessonInterface;
use Illuminate\Support\Facades\Storage;
use App\Traits\UploadTrait;

class LessonService
{
    use UploadTrait;
    public function __construct(protected LessonInterface $lessonRepository)
    {
    }

    public function all()
    {
        return $this->lessonRepository->all();
    }

    public function create($data)
    {
        foreach (['image','video','pdf'] as $file) {
            if ($data->$file) {
                $data[$file] = $this->upload("public","lessons/".$file, $data->$file);
            }
        }
        return $this->lessonRepository->create($data->toArray());
    }

    public function update($lesson,$data)
    {
        if ($data->image) {
            $data['image'] = $this->upload("public","lessons", $data->image);
            if ($lesson->image) {
                $this->deleteFile("public", $lesson->image);
            }
        }
        if ($data->video) {
            $data['video'] =$this->upload("public","videos", $data->video);
            if (!$lesson->videos->isEmpty()) {
                foreach ($lesson->videos as $video) {
                   $this->deleteFile("public",$video);
                }
            }
        }
        return $this->lessonRepository->update($lesson, $data->toArray());
    }

    public function delete($lesson)
    {
        if ($lesson->image) {
            $this->deleteFile("public",$lesson->image);
        }
        if ($lesson->videos) {
            foreach ($lesson->videos as $video) {
                 $this->deleteFile("public",$video->video_url);
            }
        }
        return $this->lessonRepository->delete($lesson);
    }
}
