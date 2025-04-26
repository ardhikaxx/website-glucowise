<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            DataKesehatanSeeder::class,
            EdukasiSeeder::class,
            HasilScreeningSeeder::class,
            JawabanScreeningSeeder::class,
            PenggunaSeeder::class,
            PertanyaanScreeningSeeder::class,
            RiwayatKesehatanSeeder::class,
            TesScreeningSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
