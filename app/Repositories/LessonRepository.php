<?php

namespace App\Repositories;

use App\Models\Video;
use App\Models\Lesson;
use App\Models\Student;
use App\Jobs\SendNotificationJob;
use App\Interfaces\LessonInterface;
use App\Jobs\SendNotificationFirebaseJob;
use App\Notifications\StudentAddingLessonNotification;


class LessonRepository implements LessonInterface
{
    public function all()
    {
        $id = auth()->user('teacher')->subject()->pluck('id')->toArray();
        return Lesson::with(['files','subject.classroom','videos','unit'])->whereIn('subject_id',$id)->latest('created_at')->get();
    }

    public function create(array $data)
    {
        // dd(phpinfo());
        $lesson = Lesson::create($data);
        $lesson->files()->create([
            'file_path' => $data['pdf']
        ]);
        $lesson->videos()->create([
            'video_url' => $data['video']
        ]);

        
        $this->sendNotification($lesson);
        return $lesson->load('videos','subject');
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


    protected function sendNotification($lesson)
    {
        $students = Student::where('classroom_id', $lesson->subject->classroom_id)->get();
        $tokens = $students->flatMap(fn ($student) => $student->firebaseTokens->pluck('token'))->toArray();
        if (!empty($tokens)) {
            SendNotificationFirebaseJob::dispatch($tokens, $lesson->title, $lesson->description, $lesson->image);
        }
        if ($students->isNotEmpty()) {
            SendNotificationJob::dispatch($students, StudentAddingLessonNotification::class, $lesson->title, $lesson->description, $lesson->image);
        }
    }
}
