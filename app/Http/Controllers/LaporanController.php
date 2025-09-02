<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatKesehatan;
use App\Models\DataKesehatan;
use Carbon\Carbon;
use App\Models\Pengguna;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month');

        $riwayatKesehatan = RiwayatKesehatan::with(['dataKesehatan.pengguna'])
            ->join('data_kesehatan', 'data_kesehatan.id_data', '=', 'riwayat_kesehatan.id_data')
            ->select('riwayat_kesehatan.id_riwayat', 'riwayat_kesehatan.id_data', 'riwayat_kesehatan.id_admin', 'riwayat_kesehatan.kategori_risiko', 'riwayat_kesehatan.catatan', 'data_kesehatan.nik', 'data_kesehatan.tanggal_pemeriksaan', 'data_kesehatan.gula_darah')
            ->whereIn('data_kesehatan.nik', function ($query) {
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
            ->whereIn('data_kesehatan.nik', function ($query) {
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
    public function show($nik)
    {
        // Ambil semua data kesehatan berdasarkan NIK dan urutkan berdasarkan bulan dan tahun, lalu tanggal pemeriksaan terbaru
        $dataKesehatan = DataKesehatan::join('pengguna', 'data_kesehatan.nik', '=', 'pengguna.nik') // Join dengan tabel pengguna berdasarkan NIK
            ->join('riwayat_kesehatan', 'data_kesehatan.id_data', '=', 'riwayat_kesehatan.id_data') // Join dengan tabel riwayat_kesehatan berdasarkan id_data
            ->where('data_kesehatan.nik', $nik) // Menggunakan NIK pengguna
            ->orderBy('data_kesehatan.tanggal_pemeriksaan', 'desc') // Mengurutkan berdasarkan tanggal pemeriksaan terbaru
            ->get();



        // Kelompokkan data berdasarkan bulan dan tahun
        $dataKesehatanGrouped = $dataKesehatan->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_pemeriksaan)->format('Y-m'); // Menggunakan format tahun-bulan
        });

        // Ambil data terbaru untuk setiap bulan
        $latestDataPerMonth = $dataKesehatanGrouped->map(function ($group) {
            return $group->first(); // Ambil data pertama (terbaru) dari setiap grup bulan
        });

        // Jika data tidak ditemukan, redirect atau tampilkan error
        if ($latestDataPerMonth->isEmpty()) {
            return redirect()->route('laporan.index')->with('error', 'Data tidak ditemukan!');
        }

        // Menghitung umur dari tanggal lahir pengguna
        $tanggalLahir = $latestDataPerMonth->first()->pengguna->tanggal_lahir; // Ambil tanggal lahir dari data pengguna
        $umur = Carbon::parse($tanggalLahir)->age; // Menggunakan Carbon untuk menghitung umur

        // Kembalikan view dengan data yang ditampilkan
        return view('layouts.Laporan.detail_kesehatan', compact('latestDataPerMonth', 'umur'));
    }

    public function printPdf($nik)
    {
        // Ambil data pengguna beserta riwayat kesehatannya berdasarkan nik
        $pengguna = Pengguna::with('dataKesehatan')
            ->where('nik', $nik)
            ->first();

        // Cek apakah data ditemukan
        if (!$pengguna) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Ambil data riwayat kesehatan terkait
        $riwayatKesehatan = RiwayatKesehatan::whereIn('id_data', $pengguna->dataKesehatan->pluck('id_data'))
            ->get();

        // Gabungkan data dataKesehatan dan riwayatKesehatan
        $combinedData = $pengguna->dataKesehatan->map(function ($data) use ($riwayatKesehatan) {
            $riwayat = $riwayatKesehatan->where('id_data', $data->id_data)->first();
            $data->kategori_risiko = $riwayat ? $riwayat->kategori_risiko : null;
            $data->catatan = $riwayat ? $riwayat->catatan : null;
            return $data;
        });

        // Ambil data riwayat kesehatan terakhir per bulan
        $latestDataPerMonth = $combinedData->groupBy(function ($date) {
            return \Carbon\Carbon::parse($date->tanggal_pemeriksaan)->format('Y-m');
        });

        // Generate data untuk QR Code
        $qrData = [
            'nama_lengkap' => $pengguna->nama_lengkap,
            'nik' => $pengguna->nik,
            'alamat_lengkap' => $pengguna->alamat_lengkap,
            'tanggal_lahir' => $pengguna->tanggal_lahir,
            'jenis_kelamin' => $pengguna->jenis_kelamin,
            'email' => $pengguna->email,
            'nomor_rekam_medis' => 'RM' . date('Y') . sprintf('%04d', $pengguna->nik),
            'tanggal_cetak' => date('d F Y, H:i')
        ];

        $qrCode = base64_encode(QrCode::format('svg')
            ->size(150)
            ->errorCorrection('H')
            ->generate(json_encode($qrData)));


        $pdf = Pdf::loadView('layouts.Laporan.pdf', [
            'pengguna' => $pengguna,
            'latestDataPerMonth' => $latestDataPerMonth,
            'umur' => $this->calculateAge($pengguna->tanggal_lahir),
            'qrCode' => $qrCode,
            'qrData' => $qrData
        ]);

        // Unduh PDF
        return $pdf->stream('laporan_kesehatan_' . $nik . '.pdf');
    }

    public function calculateAge($tanggalLahir)
    {
        // Menghitung umur berdasarkan tanggal lahir
        return \Carbon\Carbon::parse($tanggalLahir)->age;
    }
}

