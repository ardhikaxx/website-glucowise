<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\User::create([
        'nomor_identitas' => '1234567890',
        'nama_lengkap' => 'John Doe',
        'alamat' => 'Jl. Contoh Alamat No. 1',
        'telepon' => '08123456789',
        'email' => 'johndoe@example.com',
        'tanggal_lahir' => '1990-01-01',
        'jenis_kelamin' => 'L',
        'pekerjaan' => 'Software Engineer',
        'agama' => 'Islam',
        'status_kawin' => 'Menikah',
        'kewarganegaraan' => 'WNI',
    ]);
}

}
