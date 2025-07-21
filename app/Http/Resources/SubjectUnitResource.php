<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectUnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [
            'name' => $this->name,
            'units' => $this->lessons
                ->groupBy(fn($lesson) => $lesson->unit?->title)
                ->map(function ($lessons, $unitTitle) {
                    return [
                        'unit' => $unitTitle,
                        'lessons' => $lessons->map(function ($lesson) {
                            return [
                                'id' => $lesson->id,
                                'title' => $lesson->title,
                                'description' => $lesson->description,
                                'image' => $lesson->image ? asset('storage/' . $lesson->image) : null,
                                'videos' => $lesson->videos->map(function ($video) {
                                    return [
                                        'id' => $video->id,
                                       'video_url' => route('video.stream', ['filename' => basename($video->video_url)]),
                                    ];
                                }),
                                'files' => $lesson->files->map(function ($file) {
                                    return [
                                        'id' => $file->id,
                                        'file_path' => asset('storage/' . $file->file_path),
                                    ];
                                }),
                            ];
                        })->values(),
                    ];
                })->values(),
        ];
    }
}
