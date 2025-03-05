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
        $tesScreening = TesScreening::first();
        $pertanyaan1 = PertanyaanScreening::first();
        $jawaban1 = JawabanScreening::first(); // Pastikan ini tidak null

        // Cek apakah data jawaban ada
        if ($jawaban1) {
            HasilScreening::create([
                'id_screening' => $tesScreening->id_screening,
                'id_pertanyaan' => $pertanyaan1->id_pertanyaan,
                'id_jawaban' => $jawaban1->id_jawaban,
            ]);
        } else {
            echo "Jawaban pertama tidak ditemukan!";
        }
    }
}
