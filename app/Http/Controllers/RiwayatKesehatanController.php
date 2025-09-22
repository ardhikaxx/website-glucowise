<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKesehatan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RiwayatKesehatanController extends Controller
{
    // Menampilkan daftar Riwayat Kesehatan
    public function index()
    {
        // Query to get the latest data for each user within a specific year
        $riwayatKesehatan = DB::table('riwayat_kesehatan')
            ->join('data_kesehatan', 'riwayat_kesehatan.id_data', '=', 'data_kesehatan.id_data')
            ->join('pengguna as p', 'data_kesehatan.nik', '=', 'p.nik')
            ->join(
                DB::raw('(SELECT nik, MAX(tanggal_pemeriksaan) as latest_date 
                            FROM data_kesehatan 
                            GROUP BY nik) as latest'), // Get the latest date for each user
                'data_kesehatan.nik',
                '=',
                'latest.nik'
            )
            ->select(
                'riwayat_kesehatan.id_riwayat',
                'data_kesehatan.gula_darah',
                'data_kesehatan.umur', // Tambahkan kolom umur dari data_kesehatan
                'riwayat_kesehatan.id_data',
                'riwayat_kesehatan.id_admin',
                'riwayat_kesehatan.kategori_risiko',
                'riwayat_kesehatan.catatan',
                'latest.latest_date as tanggal_pemeriksaan',
                'p.nama_lengkap',
                'p.nik',
                'p.nomor_telepon'
            )
            ->whereColumn('data_kesehatan.tanggal_pemeriksaan', '=', 'latest.latest_date')
            ->orderBy('latest.latest_date', 'desc')
            ->paginate(10); // Paginate the results

        return view('layouts.Riwayat-kesehatan.riwayat_kesehatan', compact('riwayatKesehatan'));
    }

    public function search(Request $request)
    {
        // Menangkap parameter pencarian
        $search = $request->query('search'); // Menangkap input pencarian berdasarkan nama

        // Query untuk mendapatkan data kesehatan terbaru per pengguna
        $riwayatKesehatan = DB::table('riwayat_kesehatan')
            ->join('data_kesehatan', 'riwayat_kesehatan.id_data', '=', 'data_kesehatan.id_data')
            ->join('pengguna as p', 'data_kesehatan.nik', '=', 'p.nik')
            ->join(
                DB::raw('(SELECT nik, MAX(tanggal_pemeriksaan) as latest_date 
                        FROM data_kesehatan 
                        GROUP BY nik) as latest'), // Dapatkan tanggal terbaru per pengguna
                'data_kesehatan.nik',
                '=',
                'latest.nik'
            )
            ->select(
                'riwayat_kesehatan.id_riwayat',
                'data_kesehatan.gula_darah',
                'data_kesehatan.umur', // Tambahkan kolom umur dari data_kesehatan
                'riwayat_kesehatan.id_data',
                'riwayat_kesehatan.id_admin',
                'riwayat_kesehatan.kategori_risiko',
                'riwayat_kesehatan.catatan',
                'latest.latest_date as tanggal_pemeriksaan',
                'p.nama_lengkap',
                'p.nik',
                'p.nomor_telepon'
            )
            ->whereColumn('data_kesehatan.tanggal_pemeriksaan', '=', 'latest.latest_date') // Memastikan hanya yang terbaru
            ->when($search, function ($query, $search) {
                // Menambahkan kondisi pencarian berdasarkan nama_lengkap
                return $query->where('p.nama_lengkap', 'like', "%$search%");
            })
            ->orderBy('latest.latest_date', 'desc') // Urutkan berdasarkan tanggal pemeriksaan terbaru
            ->paginate(10); // Paginate the results

        // Mengirim data ke view
        return view('layouts.Riwayat-kesehatan.riwayat_kesehatan', compact('riwayatKesehatan'));
    }

    public function create()
    {
        return view('riwayatKesehatan.create');
    }

    // Menyimpan data Riwayat Kesehatan baru
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'nomor_kk' => 'required|unique:riwayat_kesehatan,nomor_kk',
            'ibu' => 'required',
            'ayah' => 'required',
            'telepon' => 'required',
            'deskripsi' => 'required',
            'dokter' => 'required',
            'diagnosa' => 'required',
            'pengobatan' => 'required',
        ]);

        // Simpan data baru
        RiwayatKesehatan::create($request->all());

        // Redirect setelah sukses
        return redirect()->route('riwayatKesehatan.index')->with('success', 'Data Riwayat Kesehatan berhasil ditambahkan!');
    }

    public function edit($id_riwayat)
    {
        // Cari data RiwayatKesehatan berdasarkan id_riwayat
        $data = RiwayatKesehatan::find($id_riwayat);  // Menggunakan id_riwayat untuk mencari

        if (!$data) {
            return redirect()->route('riwayatKesehatan.index')->with('error', 'Data tidak ditemukan!');
        }

        return view('layouts.Riwayat-kesehatan.edit_riwayat', compact('data'));
    }

    // Mengupdate data Riwayat Kesehatan berdasarkan id_riwayat
    public function update(Request $request, $id_data)
    {
        // Validasi input
        $request->validate([
            'kategori_risiko' => 'required|in:Rendah,Sedang,Tinggi',
            'catatan' => 'nullable|string',  // Ganti dengan 'catatan' yang benar
        ]);

        // Cari data berdasarkan id_riwayat dan update
        $data = RiwayatKesehatan::findOrFail($id_data);

        // Simpan perubahan
        $data->update([
            'kategori_risiko' => $request->kategori_risiko,
            'catatan' => $request->catatan, // Perbaiki nama kolom menjadi 'catatan'
        ]);

        // Flash message untuk memberi tahu pengguna
        return redirect()->route('riwayatKesehatan.show', ['nik' => $data->dataKesehatan->nik])->with('success', 'Riwayat Kesehatan berhasil diperbarui!');
    }

    // Menampilkan detail data Riwayat Kesehatan berdasarkan NIK
    public function show($nik)
    {
        // Ambil data RiwayatKesehatan berdasarkan NIK dan relasi dengan DataKesehatan
        $riwayatKesehatan = RiwayatKesehatan::whereHas('dataKesehatan', function ($query) use ($nik) {
            $query->where('nik', $nik); // Filter data berdasarkan NIK
        })
            ->with('dataKesehatan') // Eager load the dataKesehatan relationship
            ->get(); // Ambil semua data riwayat kesehatan yang terkait dengan NIK

        // Jika data tidak ditemukan
        if ($riwayatKesehatan->isEmpty()) {
            return redirect()->route('riwayatKesehatan.index')->with('error', 'Data tidak ditemukan!');
        }

        // Kelompokkan data berdasarkan bulan dan tahun
        $dataGroupedByMonth = $riwayatKesehatan->groupBy(function ($item) {
            return Carbon::parse($item->dataKesehatan->tanggal_pemeriksaan)->format('Y-m'); // Format berdasarkan tahun-bulan
        });

        // Ambil data terbaru untuk setiap bulan
        $latestDataPerMonth = $dataGroupedByMonth->map(function ($group) {
            return $group->sortByDesc(function ($item) {
                return Carbon::parse($item->dataKesehatan->tanggal_pemeriksaan); // Mengurutkan berdasarkan tanggal terbaru
            })->first(); // Ambil data pertama setelah diurutkan (terbaru)
        });

        // Jika data terbaru per bulan kosong, redirect ke index
        if ($latestDataPerMonth->isEmpty()) {
            return redirect()->route('riwayatKesehatan.index')->with('error', 'Data tidak ditemukan!');
        }

        // Mengambil umur dari data kesehatan (bukan menghitung dari tanggal lahir)
        $umur = $latestDataPerMonth->first()->dataKesehatan->umur; // Ambil umur dari data kesehatan

        // Kembalikan view dengan data yang ditampilkan
        return view('layouts.Riwayat-kesehatan.detail_riwayat', compact('latestDataPerMonth', 'umur'));
    }
}