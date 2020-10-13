<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kantor extends Model
{
    protected $table = 'kantor';
    protected $fillable = [
        'kabupaten_id', 'nama', 'kepala_kantor', 'kasi', 'nip_kasi', 'alamat', 'no_telepon', 'ibukota'
    ];
}
