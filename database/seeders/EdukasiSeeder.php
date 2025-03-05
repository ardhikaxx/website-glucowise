<?php

namespace Database\Seeders;

use App\Models\Edukasi;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class EdukasiSeeder extends Seeder
{
    public function run()
    {
        $admin = Admin::first(); // Ambil admin pertama
        
        Edukasi::create([
            'id_admin' => $admin->id_admin,
            'kategori' => 'Dasar Diabetes',
            'judul' => 'Edukasi Dasar tentang Diabetes',
            'deskripsi' => 'Pentingnya menjaga pola makan bagi penderita diabetes.',
            'gambar' => 'image.png',
            'tanggal_publikasi' => now(),
        ]);
    }
}
