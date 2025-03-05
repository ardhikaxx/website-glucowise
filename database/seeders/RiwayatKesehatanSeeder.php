<?php

namespace Database\Seeders;

use App\Models\RiwayatKesehatan;
use App\Models\DataKesehatan;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class RiwayatKesehatanSeeder extends Seeder
{
    public function run()
    {
        $dataKesehatan = DataKesehatan::first();
        $admin = Admin::first(); // Ambil admin pertama
        
        RiwayatKesehatan::create([
            'id_data' => $dataKesehatan->id_data,
            'id_admin' => $admin->id_admin,
            'kategori_risiko' => 'Sedang',
            'catatan' => 'Riwayat kesehatan dalam batas normal.',
        ]);
    }
}
