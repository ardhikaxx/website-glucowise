<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pengguna;
use App\Models\DataKesehatan;
use Carbon\Carbon;
use App\Models\RiwayatKesehatan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        // Ambil tahun yang dipilih, jika tidak ada, set default ke tahun saat ini
        $selectedYear = $request->input('year', Carbon::now()->year);

        // Dapatkan jumlah admin dan pengguna
        $totalAdmins = Admin::count();
        $bidanCount = Admin::where('hak_akses', 'Bidan')->count();
        $kaderCount = Admin::where('hak_akses', 'Kader')->count();
        $totalPengguna = Pengguna::count();
        $totalPemeriksaan = DataKesehatan::count();

        // Menyiapkan data untuk grafik risiko diabetes (per bulan sepanjang tahun)
        $chartData = [];
        $months = [];
        $riskData = [
            'Rendah' => [],
            'Sedang' => [],
            'Tinggi' => []
        ];

        // Ambil data kesehatan untuk seluruh bulan sepanjang tahun yang dipilih
        $healthData = DataKesehatan::whereYear('tanggal_pemeriksaan', $selectedYear)->get();

        // Pastikan ada data untuk tahun yang dipilih
        if ($healthData->isEmpty()) {
            $chartData = null; // Tidak ada data untuk tahun ini
        } else {
            // Loop melalui bulan (bulan 1 hingga bulan 12) dan ambil data risiko
            for ($month = 1; $month <= 12; $month++) {
                $monthlyData = $healthData->filter(function ($item) use ($month, $selectedYear) {
                    return Carbon::parse($item->tanggal_pemeriksaan)->month == $month && 
                           Carbon::parse($item->tanggal_pemeriksaan)->year == $selectedYear;
                });

                // Hitung jumlah risiko untuk setiap kategori (Rendah, Sedang, Tinggi)
                $lowRiskCount = RiwayatKesehatan::whereIn('id_data', $monthlyData->pluck('id_data'))
                    ->where('kategori_risiko', 'Rendah')
                    ->count();

                $mediumRiskCount = RiwayatKesehatan::whereIn('id_data', $monthlyData->pluck('id_data'))
                    ->where('kategori_risiko', 'Sedang')
                    ->count();

                $highRiskCount = RiwayatKesehatan::whereIn('id_data', $monthlyData->pluck('id_data'))
                    ->where('kategori_risiko', 'Tinggi')
                    ->count();

                // Simpan data risiko untuk bulan ini
                $months[] = Carbon::create()->month($month)->format('F');
                $riskData['Rendah'][] = $lowRiskCount;
                $riskData['Sedang'][] = $mediumRiskCount;
                $riskData['Tinggi'][] = $highRiskCount;
            }

            // Menyiapkan data grafik untuk dikirimkan ke view
            $chartData = [
                'months' => $months,
                'data' => $riskData,
                'categories' => ['Rendah', 'Sedang', 'Tinggi']
            ];
        }

        // Menyiapkan data kategori umur berdasarkan tanggal lahir
        $ageCategories = ['0-18', '19-35', '36-50', '51+'];
        $ageData = [
            '0-18' => Pengguna::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, ?) <= 18', [Carbon::now()])->count(),
            '19-35' => Pengguna::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, ?) BETWEEN 19 AND 35', [Carbon::now()])->count(),
            '36-50' => Pengguna::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, ?) BETWEEN 36 AND 50', [Carbon::now()])->count(),
            '51+' => Pengguna::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, ?) >= 51', [Carbon::now()])->count()
        ];

        // Mengambil pemeriksaan terbaru
        $latestPemeriksaan = DataKesehatan::with('pengguna', 'riwayatKesehatan')
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->take(3) // Ambil 3 data terbaru
            ->get();

        // Mendapatkan daftar tahun yang tersedia
        $availableYears = DataKesehatan::selectRaw('YEAR(tanggal_pemeriksaan) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        
        // Mengembalikan tampilan dashboard dengan data yang sudah disiapkan
        return view('layouts.Dashboard.dashboard', compact(
            'totalAdmins',
            'bidanCount',
            'kaderCount',
            'totalPengguna',
            'totalPemeriksaan',
            'chartData', // Kirim chartData ke tampilan
            'ageCategories', // Kirim kategori umur
            'ageData', // Kirim data umur untuk grafik
            'selectedYear', // Kirim tahun yang dipilih
            'availableYears', // Kirim daftar tahun yang tersedia
            'latestPemeriksaan'
        ));
    }
}
