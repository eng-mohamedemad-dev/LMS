<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends BaseModel {
    use HasFactory;


    protected $fillable = ['question_text', 'options', 'correct_answer', 'quiz_id','mark'];
    public function quiz() {
        return $this->belongsTo(Quiz::class);
    }
    protected $casts = [
    'options' => 'array',
    'answers' => 'array',
];


}
