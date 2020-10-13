<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKantorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kantor', function (Blueprint $table) {
            $table->id();
            $table->int('kabupaten_id');
            $table->string('nama')->nullable();
            $table->string('kepala_kantor')->nullable();
            $table->string('nip_kepala_kantor')->nullable();
            $table->string('kasi')->nullable();
            $table->string('nip_kasi')->nullable();
            $table->string('kasubsi')->nullable();
            $table->string('nip_kasubsi')->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('ibukota')->nullable();
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
        Schema::dropIfExists('kantor');
    }
}
