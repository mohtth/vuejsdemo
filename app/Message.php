<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'content', 'from_id', 'to_id', 'read_at', 'crated_at',
    ];

    public $timestamps = false;

    protected $dates = ['created_at', 'read_at'];
}
