<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryUsers extends Model
{
    protected $table = 'users_historys';
    protected $fillable = [
        'user_id', 'berkas_id', 'no_surat_tugas', 'tanggal_pengukuran', 'status_proses'
    ];

    public function getUser()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function getBerkas()
    {
        return $this->hasOne('App\Berkas','id','berkas_id');
    }

    public function getVerifikasi()
    {
        return $this->hasMany('App\Verifikasi','history_user_id','id');
    }
}
