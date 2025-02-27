<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKesehatan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan penamaan model
    protected $table = 'kesehatan';

    // Tentukan kolom mana yang bisa diisi (fillable)
    protected $fillable = [
        'nomor_kk',
        'ibu',
        'ayah',
        'telepon',
    ];
}
