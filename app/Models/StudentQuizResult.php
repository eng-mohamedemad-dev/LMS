<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentQuizResult extends BaseModel {
    use HasFactory;


    protected $fillable = ['student_id', 'quiz_id', 'score', 'taken_at'];
    public function student() {
        return $this->belongsTo(Student::class);
    }
    public function quiz() {
        return $this->belongsTo(Quiz::class);
    }
}

