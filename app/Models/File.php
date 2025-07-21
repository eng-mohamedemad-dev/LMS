<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends BaseModel {
    use HasFactory;


    protected $fillable = ['file_path', 'lesson_id'];
    public function lesson() {
        return $this->belongsTo(Lesson::class);
    }
}

