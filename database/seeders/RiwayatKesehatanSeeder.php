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
        $admin = Admin::first();

        // Jika belum ada admin, buat satu admin default
        if (!$admin) {
            $admin = Admin::create([
                'nama_lengkap' => 'Admin Medical Web',
                'email' => 'admin@medicalweb.com',
                'password' => bcrypt('password'),
                'nomor_telepon' => '081234567890',
            ]);
        }

        $dataKesehatanList = DataKesehatan::all();

        $kategoriRisiko = [
            'Rendah',
            'Sedang',
            'Tinggi',
        ];

        $catatanRendah = [
            'Kondisi kesehatan baik, tidak ada indikasi diabetes.',
            'Parameter kesehatan dalam batas normal, pertahankan pola hidup sehat.',
            'Tidak ada risiko diabetes yang signifikan.',
            'Hasil pemeriksaan menunjukkan kondisi yang stabil dan sehat.',
            'Gaya hidup dan pola makan sudah baik, pertahankan.',
            'Tidak ditemukan faktor risiko diabetes yang perlu dikhawatirkan.',
            'Kadar gula darah dalam batas normal, terus jaga kesehatan.',
            'Profil kesehatan menunjukkan risiko diabetes yang rendah.',
            'Parameter fisik dan gula darah menunjukkan kondisi optimal.',
            'Tidak ada riwayat keluarga diabetes, risiko sangat rendah.',
        ];

        $catatanSedang = [
            'Beberapa parameter perlu diperhatikan, disarankan menjaga pola makan dan olahraga.',
            'Ada sedikit peningkatan risiko, perlu monitoring rutin.',
            'Perlu perhatian pada pola makan dan aktivitas fisik.',
            'Beberapa indikator mendekati batas normal, waspada.',
            'Disarankan untuk mengurangi konsumsi gula dan karbohidrat sederhana.',
            'Perlu meningkatkan aktivitas fisik untuk menurunkan risiko.',
            'Beberapa faktor risiko teridentifikasi, perlu penanganan preventif.',
            'Kadar gula darah sedikit meningkat, perlu kontrol rutin.',
            'Lingkar pinggang mendekati batas normal, perlu perhatian.',
            'Riwayat keluarga diabetes meningkatkan risiko, perlu waspada.',
        ];

        $catatanTinggi = [
            'Berisiko tinggi diabetes, disarankan segera konsultasi ke dokter.',
            'Parameter kesehatan menunjukkan risiko diabetes yang signifikan.',
            'Perlu penanganan medis segera untuk mencegah perkembangan diabetes.',
            'Beberapa indikator melebihi batas normal, konsultasi dokter diperlukan.',
            'Risiko komplikasi diabetes tinggi, perlu intervensi medis.',
            'Gula darah tinggi disertai faktor risiko lain, perlu penanganan serius.',
            'Kombinasi faktor risiko meningkatkan kemungkinan diabetes tipe 2.',
            'Perlu perubahan gaya hidup drastis dan pengobatan medis.',
            'Kondisi mengkhawatirkan, segera lakukan pemeriksaan lebih lanjut.',
            'Risiko sangat tinggi, perlu monitoring ketat dan pengobatan.',
        ];

        foreach ($dataKesehatanList as $index => $data) {
            // Tentukan kategori risiko berdasarkan parameter kesehatan
            $risiko = $this->tentukanKategoriRisiko($data);
            
            // Pilih catatan secara acak berdasarkan kategori risiko
            $catatan = match($risiko) {
                'Rendah' => $catatanRendah[array_rand($catatanRendah)],
                'Sedang' => $catatanSedang[array_rand($catatanSedang)],
                'Tinggi' => $catatanTinggi[array_rand($catatanTinggi)],
            };

            RiwayatKesehatan::create([
                'id_data' => $data->id_data,
                'id_admin' => $admin->id_admin,
                'kategori_risiko' => $risiko,
                'catatan' => $catatan,
                'created_at' => $data->tanggal_pemeriksaan, // Tanggal dibuat beberapa hari setelah pemeriksaan
            ]);
        }
    }

    /**
     * Menentukan kategori risiko berdasarkan parameter data kesehatan
     */
    private function tentukanKategoriRisiko($dataKesehatan)
    {
        $skor = 0;
        
        // Faktor 1: Riwayat keluarga diabetes
        if ($dataKesehatan->riwayat_keluarga_diabetes == 'Ya') {
            $skor += 3;
        }
        
        // Faktor 2: Umur (semakin tua semakin berisiko)
        if ($dataKesehatan->umur >= 45) {
            $skor += 3;
        } elseif ($dataKesehatan->umur >= 35) {
            $skor += 2;
        } elseif ($dataKesehatan->umur >= 25) {
            $skor += 1;
        }
        
        // Faktor 3: BMI (Body Mass Index)
        $tinggiMeter = $dataKesehatan->tinggi_badan / 100;
        $bmi = $dataKesehatan->berat_badan / ($tinggiMeter * $tinggiMeter);
        
        if ($bmi >= 30) {
            $skor += 3;
        } elseif ($bmi >= 25) {
            $skor += 2;
        } elseif ($bmi >= 23) {
            $skor += 1;
        }
        
        // Faktor 4: Gula darah
        if ($dataKesehatan->gula_darah >= 126) {
            $skor += 3;
        } elseif ($dataKesehatan->gula_darah >= 110) {
            $skor += 2;
        } elseif ($dataKesehatan->gula_darah >= 100) {
            $skor += 1;
        }
        
        // Faktor 5: Lingkar pinggang
        if ($dataKesehatan->jenis_kelamin == 'Laki-laki') {
            if ($dataKesehatan->lingkar_pinggang >= 102) {
                $skor += 3;
            } elseif ($dataKesehatan->lingkar_pinggang >= 94) {
                $skor += 2;
            } elseif ($dataKesehatan->lingkar_pinggang >= 90) {
                $skor += 1;
            }
        } else {
            if ($dataKesehatan->lingkar_pinggang >= 88) {
                $skor += 3;
            } elseif ($dataKesehatan->lingkar_pinggang >= 80) {
                $skor += 2;
            } elseif ($dataKesehatan->lingkar_pinggang >= 80) {
                $skor += 1;
            }
        }
        
        // Faktor 6: Tekanan darah
        if ($dataKesehatan->tensi_darah >= 140) {
            $skor += 3;
        } elseif ($dataKesehatan->tensi_darah >= 130) {
            $skor += 2;
        } elseif ($dataKesehatan->tensi_darah >= 120) {
            $skor += 1;
        }
        
        // Tentukan kategori berdasarkan skor
        if ($skor >= 12) {
            return 'Tinggi';
        } elseif ($skor >= 6) {
            return 'Sedang';
        } else {
            return 'Rendah';
        }
    }
}