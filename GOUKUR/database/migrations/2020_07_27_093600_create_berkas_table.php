<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerkasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemohon')->nullable();
            $table->string('nomor_hak')->nullable();
            $table->integer('kegiatan_id');
            $table->integer('kabupaten_id');
            $table->integer('kecamatan_id');
            $table->integer('desa_id');
            $table->integer('petugas_ukur_id');
            // $table->string('catatan');
            $table->date('tanggal_pengukuran')->nullable();
            $table->string('kuasa_berkas')->nullable();
            $table->string('nama_kuasa')->nullable();
            $table->string('no_hp_kuasa')->nullable();
            $table->string('kuasa_ppat')->nullable();
            // $table->string('biaya_taktis');
            // $table->string('biaya_proses');
            $table->string('no_surat_tugas')->nullable();
            $table->string('status_proses')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berkas');
    }
}
