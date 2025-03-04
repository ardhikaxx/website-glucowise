<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kesehatan', function (Blueprint $table) {
            $table->char('nomor_kk', 16); // Kolom nomor_kk dengan tipe char(16)
            $table->string('ibu', 100); // Kolom ibu dengan tipe varchar(100)
            $table->string('ayah', 100); // Kolom ayah dengan tipe varchar(100)
            $table->string('telepon', 15)->nullable(); // Kolom telepon dengan tipe varchar(15), nullable
            $table->string('anak_1', 100)->nullable(); // Kolom anak_1 dengan tipe varchar(100), nullable
            $table->string('anak_2', 100)->nullable(); // Kolom anak_2 dengan tipe varchar(100), nullable
            $table->text('alamat')->nullable(); // Kolom alamat dengan tipe text, nullable
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at

            // Menambahkan primary key pada kolom nomor_kk
            $table->primary('nomor_kk');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('kesehatan'); // Menghapus tabel kesehatan
    }
};
