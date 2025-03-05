<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKesehatan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_kesehatan';

    protected $fillable = [
        'id_data',
        'id_admin',
        'kategori_risiko',
        'catatan',
    ];

    public function dataKesehatan()
    {
        return $this->belongsTo(DataKesehatan::class, 'id_data', 'id_data');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}
