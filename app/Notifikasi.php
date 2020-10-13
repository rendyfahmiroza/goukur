<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $fillable = [
        'user_id', 'message', 'action_user_id', 'action', 'status'
    ];
}
