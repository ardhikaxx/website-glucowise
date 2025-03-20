<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TesScreening extends Model
{
    use HasFactory;

    protected $table = 'tes_screening';
    protected $primaryKey = 'id_screening';

    protected $fillable = [
        'nik',
        'tanggal_screening',
        'skor_risiko',
        'kategori_risiko',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'nik', 'nik');
    }

    public function hasilScreening()
    {
        return $this->hasMany(HasilScreening::class, 'id_screening', 'id_screening');
    }
}
