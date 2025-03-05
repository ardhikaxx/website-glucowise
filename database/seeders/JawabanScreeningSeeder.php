<?php

namespace Database\Seeders;

use App\Models\JawabanScreening;
use App\Models\PertanyaanScreening;
use Illuminate\Database\Seeder;

class JawabanScreeningSeeder extends Seeder
{
    public function run()
    {
        $pertanyaan1 = PertanyaanScreening::first();
        $pertanyaan2 = PertanyaanScreening::skip(1)->first();
        $pertanyaan3 = PertanyaanScreening::skip(2)->first();

        JawabanScreening::create([
            'id_pertanyaan' => $pertanyaan1->id_pertanyaan,
            'jawaban' => 'Ya',
        ]);
        
        JawabanScreening::create([
            'id_pertanyaan' => $pertanyaan2->id_pertanyaan,
            'jawaban' => 'Tidak',
        ]);
        
        JawabanScreening::create([
            'id_pertanyaan' => $pertanyaan3->id_pertanyaan,
            'jawaban' => 'Ya',
        ]);
    }
}
