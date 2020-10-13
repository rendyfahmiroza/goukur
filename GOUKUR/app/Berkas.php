<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $table = 'berkas';
    protected $fillable = [
        'nama_pemohon', 'kegiatan_id',
        'nomor_hak', 'kabupaten_id',
        'kecamatan_id', 'desa_id',
        'petugas_ukur_id', 'catatan',
        'tanggal_pengukuran', 'kuasa_berkas', 'kuasa_ppat',
        'no_hp_kuasa', 'biaya_taktis',
        'biaya_proses', 'no_surat_tugas',
        'status_proses', 'pembatalan_id', 'alasan', 'fileDwg'
    ];

    public function pengguna()
    {
        return $this->hasOne('App\User','id','petugas_ukur_id');
    }

    public function ppat()
    {
        return $this->hasOne('App\User','id','kuasa_ppat');
    }

    public function kantor()
    {
        return $this->hasOne('App\Kantor','kabupaten_id','kabupaten_id');
    }

    public function pembatalan()
    {
        return $this->hasOne('App\Pembatalan','id','pembatalan_id');
    }

    public function kegiatan()
    {
        return $this->hasOne('App\Kegiatan','id','kegiatan_id');
    }
}
