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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_identitas')->unique(); // NIK atau ID pengguna
            $table->string('nama_lengkap'); // Nama lengkap pengguna
            $table->string('alamat'); // Alamat pengguna
            $table->string('telepon')->nullable(); // Nomor telepon pengguna
            $table->string('email')->unique()->nullable(); // Email pengguna
            $table->date('tanggal_lahir'); // Tanggal lahir
            $table->enum('jenis_kelamin', ['L', 'P']); // Jenis kelamin
            $table->string('pekerjaan')->nullable(); // Pekerjaan pengguna
            $table->string('agama')->nullable(); // Agama pengguna
            $table->string('status_kawin')->nullable(); // Status pernikahan
            $table->string('kewarganegaraan')->default('WNI'); // Kewarganegaraan
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::dropIfExists('users');
}
};
