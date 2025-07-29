<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirebaseToken extends Model
{
    protected $fillable = ['token'];

    public function tokenable()
    {
        return $this->morphTo();
    }
}
