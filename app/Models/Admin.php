<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin'; // Nama tabel di database
    protected $primaryKey = 'id_admin'; // Tentukan primary key yang benar
    public $timestamps = false; // Jika tabel tidak memiliki timestamps

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'jenis_kelamin',
        'hak_akses',
    ];

    protected $hidden = [
        'password', // Laravel akan otomatis mengenkripsi password
        'remember_token',
    ];

    /**
     * Relasi ke tabel Riwayat Kesehatan.
     * id_admin digunakan sebagai foreign key.
     */
    public function riwayatKesehatan()
    {
        return $this->hasMany(RiwayatKesehatan::class, 'id_admin', 'id_admin');
    }

    /**
     * Relasi ke tabel Edukasi.
     * id_admin digunakan sebagai foreign key.
     */
    public function edukasi()
    {
        return $this->hasMany(Edukasi::class, 'id_admin', 'id_admin');
    }
}
