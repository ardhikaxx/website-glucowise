<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlucoCare extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'gluco_care';
    protected $primaryKey = 'id_care';

    // Kolom-kolom yang boleh diisi (fillable)
    protected $fillable = [
        'nik',
        'tanggal',
        'nama_obat',
        'dosis',
        'jam_minum',
    ];

    // Jika kolom waktu menggunakan format timestamp
    public $timestamps = true;

    // Mendefinisikan relasi dengan model Pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'nik', 'nik');
    }
}
