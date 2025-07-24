<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends BaseModel {
    use HasFactory;

    protected $fillable = ['title', 'subject_id', 'description', 'image','unit_id'];
    public function subject() {
        return $this->belongsTo(Subject::class);
    }
    public function files() {
        return $this->hasMany(File::class);
    }
    public function videos() {
        return $this->hasMany(Video::class);
    }

    public function unit() {
        return $this->belongsTo(Unit::class);
    }

    public function quizzes() {
        return $this->hasMany(Quiz::class);
    }
    public function favoritedByStudents()
    {
        return $this->belongsToMany(Student::class, 'favorite_lessons')->withTimestamps();
    }

}

