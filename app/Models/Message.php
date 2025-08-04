<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Message extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'messageable_type',
        'messageable_id'
    ];

    public function messageable()
    {
        return $this->morphTo();
    }
}
