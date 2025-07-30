<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends BaseModel {
    use HasFactory;


    protected $fillable = ['title', 'subject_id','lesson_id','duration'];
    public function subject() {
        return $this->belongsTo(Subject::class);
    }
    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function lesson() {
        return $this->belongsTo(Lesson::class);
    }
}

