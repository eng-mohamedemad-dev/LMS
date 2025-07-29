<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends BaseModel {
    use HasFactory;


    protected $fillable = ['video_url', 'lesson_id'];
    public function lesson() {
        return $this->belongsTo(Lesson::class);
    }
}

