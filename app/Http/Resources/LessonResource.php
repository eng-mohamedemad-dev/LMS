<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'subject' => $this->subject->name,
            'classroom' => $this->subject->classroom->name,
            'unit' => $this->unit->title,
            'teacher' => $this->subject->teacher->name,
            'description' => $this->description,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'videos' => $this->videos->map(function ($video) {
                return [
                    'id' => $video->id,
                    'video_url' => asset('storage/' . $video->video_url),
                ];
            }),
            "files" => $this->files->map(function ($file) {
                return [
                    'id' => $file->id,
                    'file_path' => asset('storage/' . $file->file_path),
                ];
            }),
        ];
    }
}
