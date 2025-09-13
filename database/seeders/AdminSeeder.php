<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $healthcareWorkers = [
            // Dokter
            [
                'nama_lengkap' => 'Dr. Ahmad Fauzi, Sp.PD-KEMD',
                'email' => 'ardhikayanuar58@gmail.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Laki-laki',
                'hak_akses' => 'Dokter',
                'nomor_telepon' => '085933648537',
            ],
            [
                'nama_lengkap' => 'Dr. Siti Rahayu, Sp.PD-KEMD',
                'email' => 'siti.rahayu@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Perempuan',
                'hak_akses' => 'Dokter',
                'nomor_telepon' => '081355577799',
            ],
            [
                'nama_lengkap' => 'Dr. Rina Wijaya, Sp.OG',
                'email' => 'rina.wijaya@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Perempuan',
                'hak_akses' => 'Dokter',
                'nomor_telepon' => '081366699922',
            ],
            [
                'nama_lengkap' => 'Dr. Budi Santoso, Sp.A',
                'email' => 'budi.santoso@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Laki-laki',
                'hak_akses' => 'Dokter',
                'nomor_telepon' => '081244466688',
            ],
            [
                'nama_lengkap' => 'Dr. Agus Setiawan, Sp.B',
                'email' => 'agus.setiawan@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Laki-laki',
                'hak_akses' => 'Dokter',
                'nomor_telepon' => '081277788899',
            ],
            [
                'nama_lengkap' => 'Dr. Maya Sari, Sp.KJ',
                'email' => 'maya.sari@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Perempuan',
                'hak_akses' => 'Dokter',
                'nomor_telepon' => '081388899900',
            ],
            [
                'nama_lengkap' => 'Dr. Hendra Gunawan, Sp.OT',
                'email' => 'hendra.gunawan@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Laki-laki',
                'hak_akses' => 'Dokter',
                'nomor_telepon' => '081299900011',
            ],
            [
                'nama_lengkap' => 'Dr. Andi Pratama, Sp.U',
                'email' => 'andi.pratama@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Laki-laki',
                'hak_akses' => 'Dokter',
                'nomor_telepon' => '081211122233',
            ],
            [
                'nama_lengkap' => 'Dr. Diana Putri, Sp.KK',
                'email' => 'diana.putri@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Perempuan',
                'hak_akses' => 'Dokter',
                'nomor_telepon' => '081222233344',
            ],
            [
                'nama_lengkap' => 'Dr. Rizky Maulana, Sp.S',
                'email' => 'rizky.maulana@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Laki-laki',
                'hak_akses' => 'Dokter',
                'nomor_telepon' => '081233344455',
            ],

            // Perawat
            [
                'nama_lengkap' => 'Maria S.Kep, Ners',
                'email' => 'maria@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Perempuan',
                'hak_akses' => 'Perawat',
                'nomor_telepon' => '081298765432',
            ],
            [
                'nama_lengkap' => 'Dewi Anggraeni, S.Kep',
                'email' => 'dewi.anggraeni@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Perempuan',
                'hak_akses' => 'Perawat',
                'nomor_telepon' => '081311122233',
            ],
            [
                'nama_lengkap' => 'Rudi Hermawan, S.Kep',
                'email' => 'rudi.hermawan@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Laki-laki',
                'hak_akses' => 'Perawat',
                'nomor_telepon' => '081322233344',
            ],
            [
                'nama_lengkap' => 'Sari Indah, Ners',
                'email' => 'sari.indah@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Perempuan',
                'hak_akses' => 'Perawat',
                'nomor_telepon' => '081333344455',
            ],
            [
                'nama_lengkap' => 'Joko Prasetyo, S.Kep',
                'email' => 'joko.prasetyo@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Laki-laki',
                'hak_akses' => 'Perawat',
                'nomor_telepon' => '081344455566',
            ],
            [
                'nama_lengkap' => 'Ani Lestari, Ners',
                'email' => 'ani.lestari@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Perempuan',
                'hak_akses' => 'Perawat',
                'nomor_telepon' => '081355566677',
            ],
            [
                'nama_lengkap' => 'Bambang Sutrisno, S.Kep',
                'email' => 'bambang.sutrisno@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Laki-laki',
                'hak_akses' => 'Perawat',
                'nomor_telepon' => '081366677788',
            ],
            [
                'nama_lengkap' => 'Citra Dewi, Ners',
                'email' => 'citra.dewi@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Perempuan',
                'hak_akses' => 'Perawat',
                'nomor_telepon' => '081377788899',
            ],
            [
                'nama_lengkap' => 'Eko Nugroho, S.Kep',
                'email' => 'eko.nugroho@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Laki-laki',
                'hak_akses' => 'Perawat',
                'nomor_telepon' => '081388899900',
            ],
            [
                'nama_lengkap' => 'Fitri Handayani, Ners',
                'email' => 'fitri.handayani@klinik.com',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'Perempuan',
                'hak_akses' => 'Perawat',
                'nomor_telepon' => '081399900011',
            ]
        ];

        foreach ($healthcareWorkers as $worker) {
            Admin::create($worker);
        }
    }
}