<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('edukasi', function (Blueprint $table) {
            $table->id(); // Kolom id dengan auto-increment (int(11))
            $table->string('judul', 255); // Kolom judul dengan tipe varchar(255)
            $table->text('isi'); // Kolom isi dengan tipe text
            $table->string('gambar', 255); // Kolom gambar dengan tipe varchar(255)
            $table->timestamp('tanggal')->default(DB::raw('CURRENT_TIMESTAMP')); // Kolom tanggal dengan default current_timestamp
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('edukasi'); // Menghapus tabel edukasi
    }
};
