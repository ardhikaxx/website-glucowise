<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'nama_lengkap' => 'Bidan A',
            'email' => 'bidan1@example.com',
            'password' => bcrypt('password'),
            'jenis_kelamin' => 'Perempuan',
            'hak_akses' => 'Bidan',
        ]);
        
        Admin::create([
            'nama_lengkap' => 'Kader B',
            'email' => 'kader1@example.com',
            'password' => bcrypt('password'),
            'jenis_kelamin' => 'Laki-laki',
            'hak_akses' => 'Kader',
        ]);
        
        Admin::create([
            'nama_lengkap' => 'Bidan C',
            'email' => 'bidan2@example.com',
            'password' => bcrypt('password'),
            'jenis_kelamin' => 'Perempuan',
            'hak_akses' => 'Bidan',
        ]);
    }
}
