<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable , HasUuids, HasRoles;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['name', 'email', 'password', 'status', 'phone', 'image', 'address'];
    protected $hidden = ['password'];
    public function subject() {
        return $this->hasMany(Subject::class);
    }
    public function firebaseTokens()
    {
        return $this->morphMany(FirebaseToken::class, 'tokenable');
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }
}
