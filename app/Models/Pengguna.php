<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    protected $table = 'pengguna'; // Menentukan nama tabel

    protected $primaryKey = 'nik'; // Menentukan primary key

    protected $fillable = [
        'nik',
        'email',
        'password',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat_lengkap',
        'nomor_telepon',
        'nama_ibu_kandung',
    ];

    public function tesScreening()
    {
        return $this->hasMany(TesScreening::class, 'nik', 'nik');
    }

    public function dataKesehatan()
    {
        return $this->hasMany(DataKesehatan::class, 'nik', 'nik');
    }
}
