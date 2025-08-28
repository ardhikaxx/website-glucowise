<?php

namespace Database\Seeders;

use App\Models\TesScreening;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TesScreeningSeeder extends Seeder
{
    public function run()
    {
        $penggunaList = Pengguna::all();

        foreach ($penggunaList as $pengguna) {
            // Buat 1-3 tes screening untuk setiap pengguna
            $jumlahTes = rand(1, 3);
            
            for ($i = 0; $i < $jumlahTes; $i++) {
                $skorRisiko = rand(0, 100); // Skor antara 0-100
                
                TesScreening::create([
                    'nik' => $pengguna->nik,
                    'tanggal_screening' => Carbon::now()->subDays(rand(0, 365)),
                    'skor_risiko' => $skorRisiko,
                ]);
            }
        }
    }
}