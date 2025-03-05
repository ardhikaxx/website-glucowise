<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKesehatan extends Model
{
    use HasFactory;

    protected $table = 'data_kesehatan';

    protected $fillable = [
        'nik',
        'tanggal_pemeriksaan',
        'riwayat_keluarga_diabetes',
        'umur',
        'tinggi_badan',
        'berat_badan',
        'gula_darah',
        'lingkar_pinggang',
        'tensi_darah',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'nik', 'nik');
    }

    public function riwayatKesehatan()
    {
        return $this->hasOne(RiwayatKesehatan::class, 'id_data', 'id_data');
    }
}
