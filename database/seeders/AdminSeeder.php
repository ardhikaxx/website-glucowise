<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'nama_lengkap' => 'Dr. Ahmad Fauzi, Sp.PD-KEMD',
            'email' => 'ardhikayanuar58@gmail.com',
            'password' => bcrypt('password'),
            'jenis_kelamin' => 'Laki-laki',
            'hak_akses' => 'Dokter',
            'nomor_telepon' => '085933648537',
        ]);

        Admin::create([
            'nama_lengkap' => 'Maria S.Kep, Ners',
            'email' => 'maria@gmail.com',
            'password' => bcrypt('password'),
            'jenis_kelamin' => 'Perempuan',
            'hak_akses' => 'Perawat',
            'nomor_telepon' => '081298765432',
        ]);

        Admin::create([
            'nama_lengkap' => 'Dr. Siti Rahayu, Sp.PD-KEMD',
            'email' => 'siti.rahayu@gmail.com',
            'password' => bcrypt('password'),
            'jenis_kelamin' => 'Perempuan',
            'hak_akses' => 'Dokter',
            'nomor_telepon' => '081355577799',
        ]);

        Admin::create([
            'nama_lengkap' => 'Budi Santoso, S.Kep',
            'email' => 'budi.santoso@gmail.com',
            'password' => bcrypt('password'),
            'jenis_kelamin' => 'Laki-laki',
            'hak_akses' => 'Perawat',
            'nomor_telepon' => '081244466688',
        ]);

        Admin::create([
            'nama_lengkap' => 'Dr. Rina Wijaya, Sp.PD-KEMD',
            'email' => 'rina.wijaya@gmail.com',
            'password' => bcrypt('password'),
            'jenis_kelamin' => 'Perempuan',
            'hak_akses' => 'Dokter',
            'nomor_telepon' => '081366699922',
        ]);
    }
}