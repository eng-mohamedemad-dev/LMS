<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Father extends Authenticatable {
    use HasFactory, Notifiable,HasUuids, HasRoles,HasApiTokens;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['name', 'email', 'password', 'phone','status', 'image', 'address'];
    protected $hidden = ['password'];
    public function students() {
        return $this->hasMany(Student::class);
    }
    public function firebaseTokens()
    {
        return $this->morphMany(FirebaseToken::class, 'tokenable');
    }

}

