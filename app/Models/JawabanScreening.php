<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanScreening extends Model
{
    use HasFactory;

    protected $table = 'jawaban_screening';

    protected $fillable = [
        'id_pertanyaan',
        'jawaban',
    ];

    public function pertanyaanScreening()
    {
        return $this->belongsTo(PertanyaanScreening::class, 'id_pertanyaan', 'id_pertanyaan');
    }

    public function hasilScreening()
    {
        return $this->hasMany(HasilScreening::class, 'id_jawaban', 'id_jawaban');
    }
}
