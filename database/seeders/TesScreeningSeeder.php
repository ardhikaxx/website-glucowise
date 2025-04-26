<?php

namespace Database\Seeders;

use App\Models\TesScreening;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class TesScreeningSeeder extends Seeder
{
    public function run()
    {
        $pengguna = Pengguna::first(); // Ambil pengguna pertama
        
        TesScreening::create([
            'nik' => $pengguna->nik,
            'tanggal_screening' => now(),
            'skor_risiko' => 50,
        ]);
        
        TesScreening::create([
            'nik' => Pengguna::skip(1)->first()->nik,
            'tanggal_screening' => now(),
            'skor_risiko' => 30,
            
        ]);
        
        TesScreening::create([
            'nik' => Pengguna::skip(2)->first()->nik,
            'tanggal_screening' => now(),
            'skor_risiko' => 70,
        ]);
    }
}
