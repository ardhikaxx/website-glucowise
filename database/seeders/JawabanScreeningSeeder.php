<?php

namespace Database\Seeders;

use App\Models\JawabanScreening;
use App\Models\PertanyaanScreening;
use Illuminate\Database\Seeder;

class JawabanScreeningSeeder extends Seeder
{
    public function run()
    {
        $pertanyaanList = PertanyaanScreening::all();

        // Data jawaban sesuai pertanyaan screening diabetes
        $jawabanData = [
            // Pertanyaan 1: Olahraga
            [
                'Tidak pernah (3)',
                'Jarang (2)',
                'Sering (1)',
                'Selalu (0)'
            ],
            // Pertanyaan 2: Makanan tinggi lemak
            [
                'Tidak pernah (0)',
                'Jarang (1)',
                'Sering (2)',
                'Selalu (3)'
            ],
            // Pertanyaan 3: Buah dan sayuran
            [
                'Tidak pernah (3)',
                'Jarang (2)',
                'Sering (1)',
                'Selalu (0)'
            ],
            // Pertanyaan 4: Minuman manis
            [
                'Tidak pernah (0)',
                'Jarang (1)',
                'Sering (2)',
                'Selalu (3)'
            ],
            // Pertanyaan 5: Tidur kurang dari 8 jam
            [
                'Tidak pernah (0)',
                'Jarang (1)',
                'Sering (2)',
                'Selalu (3)'
            ],
            // Pertanyaan 6: Buang air kecil malam hari
            [
                'Tidak pernah (0)',
                'Jarang (1)',
                'Sering (2)',
                'Selalu (3)'
            ],
            // Pertanyaan 7: Sering merasa haus
            [
                'Tidak pernah (0)',
                'Jarang (1)',
                'Sering (2)',
                'Selalu (3)'
            ],
            // Pertanyaan 8: Sering merasa lapar
            [
                'Tidak pernah (0)',
                'Jarang (1)',
                'Sering (2)',
                'Selalu (3)'
            ],
        ];

        foreach ($pertanyaanList as $index => $pertanyaan) {
            // Pastikan index tidak melebihi jumlah data jawaban
            if (isset($jawabanData[$index])) {
                foreach ($jawabanData[$index] as $jawaban) {
                    JawabanScreening::create([
                        'id_pertanyaan' => $pertanyaan->id_pertanyaan,
                        'jawaban' => $jawaban,
                    ]);
                }
            }
        }
    }
}
