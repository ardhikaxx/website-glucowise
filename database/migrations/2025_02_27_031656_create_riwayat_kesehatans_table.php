<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatKesehatansTable extends Migration
{
    public function up()
    {
        Schema::create('riwayat_kesehatan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kk')->unique(); // Nomor KK
            $table->string('ibu'); // Nama Ibu
            $table->string('ayah'); // Nama Ayah
            $table->string('telepon'); // Nomor Telepon
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_kesehatan');
    }
}
