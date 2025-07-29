<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends BaseModel {
    use HasFactory;
    
    protected $fillable = ['name', 'classroom_id', 'teacher_id','classification'];
    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }
    public function lessons() {
        return $this->hasMany(Lesson::class);
    }
    public function quizzes() {
        return $this->hasMany(Quiz::class);
    }
}
