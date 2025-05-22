<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatKesehatan;
use App\Models\DataKesehatan;
use App\Models\Pengguna; // Ensure Pengguna model is imported
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month');

        $riwayatKesehatan = RiwayatKesehatan::with(['dataKesehatan.pengguna'])
            ->join('data_kesehatan', 'data_kesehatan.id_data', '=', 'riwayat_kesehatan.id_data')
            ->select('riwayat_kesehatan.id_riwayat', 'riwayat_kesehatan.id_data', 'riwayat_kesehatan.id_admin', 'riwayat_kesehatan.kategori_risiko', 'riwayat_kesehatan.catatan', 'data_kesehatan.nik', 'data_kesehatan.tanggal_pemeriksaan', 'data_kesehatan.gula_darah')
            ->whereIn('data_kesehatan.nik', function($query) {
                // Get most recent record for each pengguna
                $query->selectRaw('nik')
                    ->from('data_kesehatan')
                    ->groupBy('nik')
                    ->havingRaw('MAX(tanggal_pemeriksaan) = data_kesehatan.tanggal_pemeriksaan');
            });

        if ($month) {
            $riwayatKesehatan->whereMonth('data_kesehatan.tanggal_pemeriksaan', $month);
        }

        $riwayatKesehatan = $riwayatKesehatan->orderByDesc('data_kesehatan.tanggal_pemeriksaan')->paginate(10);

        // Get distinct months for the filter dropdown
        $months = DataKesehatan::selectRaw('MONTH(tanggal_pemeriksaan) as month')
            ->distinct()
            ->orderBy('month')
            ->get();

        return view('layouts.Laporan.laporan', compact('riwayatKesehatan', 'months'));
    }

    public function searchByMonth(Request $request)
    {
        $month = $request->input('month'); // Get selected month

        // Filter by selected month and show the latest records for each user
        $riwayatKesehatan = RiwayatKesehatan::with(['dataKesehatan.pengguna'])
            ->join('data_kesehatan', 'data_kesehatan.id_data', '=', 'riwayat_kesehatan.id_data')
            ->select('riwayat_kesehatan.id_riwayat', 'riwayat_kesehatan.id_data', 'riwayat_kesehatan.id_admin', 'riwayatKesehatan.kategori_risiko', 'riwayatKesehatan.catatan', 'data_kesehatan.nik', 'data_kesehatan.tanggal_pemeriksaan', 'data_kesehatan.gula_darah')
            ->whereMonth('data_kesehatan.tanggal_pemeriksaan', $month)  // Filter by the selected month
            ->whereIn('data_kesehatan.nik', function($query) {
                // Get most recent record for each pengguna
                $query->selectRaw('nik')
                    ->from('data_kesehatan')
                    ->groupBy('nik')
                    ->havingRaw('MAX(tanggal_pemeriksaan) = data_kesehatan.tanggal_pemeriksaan');
            })
            ->orderByDesc('data_kesehatan.tanggal_pemeriksaan')  // Order by the most recent date
            ->paginate(10);

        // Get distinct months for the filter dropdown
        $months = DataKesehatan::selectRaw('MONTH(tanggal_pemeriksaan) as month')
            ->distinct()
            ->orderBy('month')
            ->get();

        return view('layouts.Laporan.laporan', compact('riwayatKesehatan', 'months'));
    }
    
}

