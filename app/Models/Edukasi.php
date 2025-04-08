<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    use HasFactory;

    protected $table = 'edukasi';

    // Menentukan kolom primary key yang digunakan
    protected $primaryKey = 'id_edukasi';

    protected $fillable = [
        'id_admin',
        'kategori',
        'judul',
        'deskripsi',
        'gambar',
        'tanggal_publikasi',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}

