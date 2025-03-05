<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'jenis_kelamin',
        'hak_akses', // menambahkan kolom hak_akses
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
