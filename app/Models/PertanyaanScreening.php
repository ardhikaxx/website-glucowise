<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanScreening extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_screening';
    protected $primaryKey = 'id_pertanyaan';

    protected $fillable = [
        'pertanyaan',
    ];

    public function jawabanScreening()
    {
        return $this->hasMany(JawabanScreening::class, 'id_pertanyaan', 'id_pertanyaan');
    }

    public function hasilScreening()
    {
        return $this->hasMany(HasilScreening::class, 'id_pertanyaan', 'id_pertanyaan');
    }
}