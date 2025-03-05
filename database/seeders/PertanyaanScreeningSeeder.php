<?php

namespace Database\Seeders;

use App\Models\PertanyaanScreening;
use Illuminate\Database\Seeder;

class PertanyaanScreeningSeeder extends Seeder
{
    public function run()
    {
        PertanyaanScreening::create([
            'pertanyaan' => 'Apakah Anda merasa pusing?',
        ]);
        
        PertanyaanScreening::create([
            'pertanyaan' => 'Apakah Anda memiliki riwayat hipertensi?',
        ]);
        
        PertanyaanScreening::create([
            'pertanyaan' => 'Apakah Anda merasa kelelahan yang berlebihan?',
        ]);
    }
}
