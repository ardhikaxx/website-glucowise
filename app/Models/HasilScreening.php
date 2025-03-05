<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilScreening extends Model
{
    use HasFactory;

    protected $table = 'hasil_screening';

    protected $fillable = [
        'id_screening',
        'id_pertanyaan',
        'id_jawaban',
    ];

    public function tesScreening()
    {
        return $this->belongsTo(TesScreening::class, 'id_screening', 'id_screening');
    }

    public function pertanyaanScreening()
    {
        return $this->belongsTo(PertanyaanScreening::class, 'id_pertanyaan', 'id_pertanyaan');
    }

    public function jawabanScreening()
    {
        return $this->belongsTo(JawabanScreening::class, 'id_jawaban', 'id_jawaban');
    }
}
