<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PenggunaSeeder::class,
            AdminSeeder::class,
            EdukasiSeeder::class,
            PertanyaanScreeningSeeder::class,
            JawabanScreeningSeeder::class,
            DataKesehatanSeeder::class,    
            RiwayatKesehatanSeeder::class,
            TesScreeningSeeder::class,
            HasilScreeningSeeder::class,
        ]);
    }
}
