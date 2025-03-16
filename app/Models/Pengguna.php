<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna'; // Menentukan nama tabel

    protected $primaryKey = 'nik'; // Menentukan primary key

    public $incrementing = false;
    protected $keyType = 'string';

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

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
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
