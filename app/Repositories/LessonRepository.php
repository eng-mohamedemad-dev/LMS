<?php

namespace App\Repositories;

use App\Models\Video;
use App\Models\Lesson;
use App\Interfaces\LessonInterface;


class LessonRepository implements LessonInterface
{
    public function all()
    {
        $id = auth()->user('teacher')->subject()->pluck('id')->toArray();
        return Lesson::with(['files','subject.classroom','videos','unit'])->whereIn('subject_id',$id)->latest('created_at')->get();
    }

    public function create(array $data)
    {
        $lesson = Lesson::create($data);
        Video::create([
            'lesson_id' => $lesson->id,
            "video_url" => $data['video']
        ]);
        return $lesson->load('videos');
    }

    public function update($lesson, array $data)
    {
        $lesson->update($data);
        if (isset($data['video']) && $data['video']) {
            if ($lesson->videos) {
                foreach ($lesson->videos as $video) {
                    $video->delete();
                }
            }
            Video::create([
                'lesson_id' => $lesson->id,
                "video_url" => $data['video']
            ]);
        }
        return $lesson->load('videos');
    }

    public function delete($lesson)
    {
        return $lesson->delete();
    }
}
