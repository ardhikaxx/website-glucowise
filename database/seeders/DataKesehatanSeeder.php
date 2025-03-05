<?php

namespace Database\Seeders;

use App\Models\DataKesehatan;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class DataKesehatanSeeder extends Seeder
{
    public function run()
    {
        $pengguna = Pengguna::first(); // Ambil pengguna pertama
        
        DataKesehatan::create([
            'nik' => $pengguna->nik,
            'tanggal_pemeriksaan' => now(),
            'riwayat_keluarga_diabetes' => 'Tidak',
            'umur' => 30,
            'tinggi_badan' => 170,
            'berat_badan' => 65,
            'gula_darah' => 100,
            'lingkar_pinggang' => 80,
            'tensi_darah' => 120,
        ]);
    }
}
