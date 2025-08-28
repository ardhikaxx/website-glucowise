<?php

namespace Database\Seeders;

use App\Models\HasilScreening;
use App\Models\TesScreening;
use App\Models\PertanyaanScreening;
use App\Models\JawabanScreening;
use Illuminate\Database\Seeder;

class HasilScreeningSeeder extends Seeder
{
    public function run()
    {
        $tesScreeningList = TesScreening::all();
        $pertanyaanList = PertanyaanScreening::all();

        foreach ($tesScreeningList as $tesScreening) {
            foreach ($pertanyaanList as $pertanyaan) {
                // Ambil semua jawaban untuk pertanyaan ini
                $jawabanList = JawabanScreening::where('id_pertanyaan', $pertanyaan->id_pertanyaan)->get();
                
                // Pilih jawaban secara acak
                $jawabanAcak = $jawabanList->random();
                
                HasilScreening::create([
                    'id_screening' => $tesScreening->id_screening,
                    'id_pertanyaan' => $pertanyaan->id_pertanyaan,
                    'id_jawaban' => $jawabanAcak->id_jawaban,
                ]);
            }
        }
    }
}