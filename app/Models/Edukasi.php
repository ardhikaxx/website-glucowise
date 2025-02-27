<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model yang di-plural-kan
    protected $table = 'edukasi';

    // Tentukan kolom yang boleh diisi (mass assignable)
    protected $fillable = ['judul', 'isi', 'gambar'];

    // Tentukan kolom yang tidak boleh diisi
    // protected $guarded = [];

    // Menyembunyikan kolom sensitif (misal gambar jika ingin dirahasiakan)
    protected $hidden = [];

    // Kolom timestamp secara default
    public $timestamps = false;
}
