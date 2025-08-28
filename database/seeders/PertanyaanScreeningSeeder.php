<?php

namespace Database\Seeders;

use App\Models\PertanyaanScreening;
use Illuminate\Database\Seeder;

class PertanyaanScreeningSeeder extends Seeder
{
    public function run()
    {
        $pertanyaanData = [
            [
                'pertanyaan' => 'Apakah Anda rutin berolahraga (renang, bersepeda, jogging) setidaknya 2 kali dalam seminggu?',
            ],
            [
                'pertanyaan' => 'Apakah Anda sering mengonsumsi makanan tinggi lemak (misalnya junk food)?',
            ],
            [
                'pertanyaan' => 'Apakah Anda sering mengonsumsi buah dan sayuran?',
            ],
            [
                'pertanyaan' => 'Apakah Anda sering mengonsumsi minuman manis secara berlebihan?',
            ],
            [
                'pertanyaan' => 'Apakah Anda sering tidur kurang dari 8 jam?',
            ],
            [
                'pertanyaan' => 'Seberapa sering Anda buang air kecil pada malam hari?',
            ],
            [
                'pertanyaan' => 'Seberapa sering Anda merasa haus?',
            ],
            [
                'pertanyaan' => 'Seberapa sering Anda merasa lapar?',
            ],
        ];

        foreach ($pertanyaanData as $pertanyaan) {
            PertanyaanScreening::create($pertanyaan);
        }
    }
}