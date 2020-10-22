<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    protected $table = 'verifikasi';
    protected $fillable = [
        'history_user_id', 'catatan', 'tanggal'
    ];
}
