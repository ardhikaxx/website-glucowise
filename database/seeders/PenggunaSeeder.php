<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    public function run()
    {
        Pengguna::create([
            'nik' => '1234567890123456',
            'email' => 'pengguna1@example.com',
            'password' => bcrypt('password'),
            'nama_lengkap' => 'Pengguna Satu',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'alamat_lengkap' => 'Jl. Pengguna Satu No.1',
            'nomor_telepon' => '081234567890',
            'nama_ibu_kandung' => 'Ibu Pengguna Satu',
        ]);
        
        Pengguna::create([
            'nik' => '1234567890123457',
            'email' => 'pengguna2@example.com',
            'password' => bcrypt('password'),
            'nama_lengkap' => 'Pengguna Dua',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1992-02-02',
            'jenis_kelamin' => 'Perempuan',
            'alamat_lengkap' => 'Jl. Pengguna Dua No.2',
            'nomor_telepon' => '081234567891',
            'nama_ibu_kandung' => 'Ibu Pengguna Dua',
        ]);
        
        Pengguna::create([
            'nik' => '1234567890123458',
            'email' => 'pengguna3@example.com',
            'password' => bcrypt('password'),
            'nama_lengkap' => 'Pengguna Tiga',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1995-03-03',
            'jenis_kelamin' => 'Laki-laki',
            'alamat_lengkap' => 'Jl. Pengguna Tiga No.3',
            'nomor_telepon' => '081234567892',
            'nama_ibu_kandung' => 'Ibu Pengguna Tiga',
        ]);
    }
}
