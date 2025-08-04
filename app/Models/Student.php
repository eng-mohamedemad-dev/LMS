<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Student extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable ,HasUuids, HasRoles;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['father_phone','name', 'email', 'password', 'father_id', 'classroom_id','status','classification', 'image', 'address'];
    protected $hidden = ['password'];
    public function father() {
        return $this->belongsTo(Father::class);
    }
    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
    public function results() {
        return $this->hasMany(StudentQuizResult::class);
    }
    public function favoriteLessons()
    {
        return $this->belongsToMany(Lesson::class, 'favorite_lessons')->withTimestamps();
    }
    public function firebaseTokens()
    {
        return $this->morphMany(FirebaseToken::class, 'tokenable');
    }
    
    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }
    protected static function boot() {
        parent::boot();
        self::deleting(function ($student) {
            $student->firebaseTokens()->delete();
            $student->results()->delete();
            $student->favoriteLessons()->delete();
            $student->notifications()->delete();
            $student->tokens()->delete();
        });
    }
}

