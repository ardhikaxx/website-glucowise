<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKesehatan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model
    protected $table = 'riwayat_kesehatan';

    // Tentukan kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'nomor_kk',
        'ibu',
        'ayah',
        'telepon',
    ];
}
