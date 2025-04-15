<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    public function up()
    {
        // Tabel Pengguna
        Schema::create('pengguna', function (Blueprint $table) {
            $table->string('nik', 16)->primary();
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('nama_lengkap', 100);
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('nomor_telepon', 15)->nullable();
            $table->string('nama_ibu_kandung', 100)->nullable();
            $table->timestamps();
        });

        // Tabel Admin
        Schema::create('gluco_care', function (Blueprint $table) {
            $table->id('id_care')->unsignedBigInteger()->autoIncrement();
            $table->string('nik', 16);
            $table->date('tanggal');
            $table->string('nama_obat');
            $table->string('dosis', 50);
            $table->time('jam_minum');
            $table->timestamps(0);

            $table->foreign('nik')->references('nik')->on('pengguna')->onDelete('cascade');
        });

        // Tabel Admin
        Schema::create('admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('nama_lengkap', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('hak_akses', ['Bidan', 'Kader']); // Kolom untuk hak akses 
            $table->timestamps();
        });

        // Tabel Tes Screening
        Schema::create('tes_screening', function (Blueprint $table) {
            $table->id('id_screening');
            $table->string('nik', 16);
            $table->foreign('nik')->references('nik')->on('pengguna')->onDelete('cascade');
            $table->dateTime('tanggal_screening');
            $table->integer('skor_risiko');
            $table->timestamps();
        });

        // Tabel Pertanyaan Screening
        Schema::create('pertanyaan_screening', function (Blueprint $table) {
            $table->id('id_pertanyaan');
            $table->text('pertanyaan');
            $table->timestamps();
        });

        // Tabel Jawaban Screening
        Schema::create('jawaban_screening', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->unsignedBigInteger('id_pertanyaan');
            $table->foreign('id_pertanyaan')->references('id_pertanyaan')->on('pertanyaan_screening')->onDelete('cascade');
            $table->text('jawaban');
            $table->timestamps();
        });

        // Tabel Hasil Screening
        Schema::create('hasil_screening', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->unsignedBigInteger('id_screening');
            $table->foreign('id_screening')->references('id_screening')->on('tes_screening')->onDelete('cascade');
            $table->unsignedBigInteger('id_pertanyaan');
            $table->foreign('id_pertanyaan')->references('id_pertanyaan')->on('pertanyaan_screening')->onDelete('cascade');
            $table->unsignedBigInteger('id_jawaban');
            $table->foreign('id_jawaban')->references('id_jawaban')->on('jawaban_screening')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabel Data Kesehatan
        Schema::create('data_kesehatan', function (Blueprint $table) {
            $table->id('id_data');
            $table->string('nik', 16);
            $table->foreign('nik')->references('nik')->on('pengguna')->onDelete('cascade');
            $table->date('tanggal_pemeriksaan');
            $table->enum('riwayat_keluarga_diabetes', ['Ya', 'Tidak']);
            $table->integer('umur');
            $table->float('tinggi_badan');
            $table->float('berat_badan');
            $table->float('gula_darah');
            $table->float('lingkar_pinggang');
            $table->float('tensi_darah');
            $table->timestamps();
        });

        // Tabel Riwayat Kesehatan
        Schema::create('riwayat_kesehatan', function (Blueprint $table) {
            $table->id('id_riwayat');
            $table->unsignedBigInteger('id_data');
            $table->foreign('id_data')->references('id_data')->on('data_kesehatan')->onDelete('cascade');
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->foreign('id_admin')->references('id_admin')->on('admin')->onDelete('cascade');
            $table->enum('kategori_risiko', ['Dalam proses', 'Rendah', 'Sedang', 'Tinggi'])->default('Dalam proses');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // Tabel Edukasi
        Schema::create('edukasi', function (Blueprint $table) {
            $table->id('id_edukasi');
            $table->unsignedBigInteger('id_admin');
            $table->foreign('id_admin')->references('id_admin')->on('admin')->onDelete('cascade');
            $table->enum('kategori', ['Dasar Diabetes', 'Manajemen Diabetes']);
            $table->string('judul', 255);
            $table->text('deskripsi');
            $table->string('gambar', 255)->nullable();
            $table->date('tanggal_publikasi');
            $table->timestamps();
        });
    }

    public function down()
    {
        // Menghapus tabel jika migrasi dibatalkan
        Schema::dropIfExists('edukasi');
        Schema::dropIfExists('riwayat_kesehatan');
        Schema::dropIfExists('data_kesehatan');
        Schema::dropIfExists('hasil_screening');
        Schema::dropIfExists('jawaban_screening');
        Schema::dropIfExists('pertanyaan_screening');
        Schema::dropIfExists('tes_screening');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('pengguna');
    }
}
