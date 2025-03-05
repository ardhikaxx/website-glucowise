<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin'; // Nama tabel
    protected $primaryKey = 'id_admin'; // Tentukan primary key yang benar
    public $timestamps = false; // Jika tidak ada timestamps

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'jenis_kelamin',
        'hak_akses',
    ];

    public function riwayatKesehatan()
    {
        return $this->hasMany(RiwayatKesehatan::class, 'id_admin', 'id_admin');
    }

    public function edukasi()
    {
        return $this->hasMany(Edukasi::class, 'id_admin', 'id_admin');
    }
}

