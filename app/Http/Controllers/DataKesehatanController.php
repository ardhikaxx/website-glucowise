<?php
namespace App\Http\Controllers;

use App\Models\DataKesehatan;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;


class DataKesehatanController extends Controller
{
    // Menampilkan halaman daftar data kesehatan
    public function index()
{
    // Mengambil data kesehatan per pengguna tanpa redundansi, hanya data terbaru berdasarkan tanggal pemeriksaan
    $dataKesehatan = DB::table('data_kesehatan')
        ->join('pengguna as p', 'data_kesehatan.nik', '=', 'p.nik')  // Aliasing the 'pengguna' table as 'p'
        ->join(DB::raw('(SELECT nik, MAX(tanggal_pemeriksaan) as latest_date FROM data_kesehatan GROUP BY nik) as latest_data'), 'data_kesehatan.nik', '=', 'latest_data.nik')
        ->select(
            'data_kesehatan.id_data',
            'data_kesehatan.nik',
            'latest_data.latest_date as tanggal_pemeriksaan', // Get the latest date for each user
            'data_kesehatan.gula_darah',
            'data_kesehatan.umur',
            'p.nama_lengkap',  // Referencing 'pengguna' table alias 'p'
            'p.nomor_telepon'  // Referencing 'pengguna' table alias 'p'
        )
        ->whereColumn('data_kesehatan.tanggal_pemeriksaan', '=', 'latest_data.latest_date') // Ensure the gula_darah comes from the latest date
        ->paginate(10); // Paginate the results

    return view('layouts.Data-kesehatan.data_kesehatan', compact('dataKesehatan'));
}

    


public function search(Request $request)
{
    // Ambil query pencarian dari input
    $search = $request->get('search');

    // Cari data kesehatan berdasarkan pencarian
    $dataKesehatan = DataKesehatan::with('pengguna') // Mengambil data kesehatan dengan relasi pengguna
        ->when($search, function ($query, $search) {
            // Pencarian berdasarkan NIK pada tabel data_kesehatan dan Nama Lengkap pada tabel pengguna
            return $query->where('nik', 'like', "%$search%")
                         ->orWhereHas('pengguna', function($query) use ($search) {
                             $query->where('nama_lengkap', 'like', "%$search%");
                         });
        })
        ->paginate(10); // Menampilkan 10 data per halaman

    // Menentukan pesan berdasarkan jenis pencarian
    $message = '';
    if ($dataKesehatan->isEmpty()) {
        if (preg_match('/^[0-9]+$/', $search)) { // Jika pencarian menggunakan NIK (angka)
            $message = 'Data NIK ' . $search . ' tidak ditemukan.';
        } else { // Jika pencarian menggunakan Nama Pengguna
            $message = 'Data Nama ' . $search . ' tidak ditemukan.';
        }
    }

    return view('layouts.Data-kesehatan.data_kesehatan', compact('dataKesehatan', 'message'));
}


    // Menampilkan halaman detail data kesehatan
   
    public function show($nik)
    {
        // Ambil semua data kesehatan berdasarkan NIK dan urutkan berdasarkan bulan dan tahun, lalu tanggal pemeriksaan terbaru
        $dataKesehatan = DataKesehatan::with('pengguna') // Mengambil data kesehatan beserta relasi dengan pengguna
            ->where('nik', $nik) // Menggunakan NIK pengguna
            ->orderBy('tanggal_pemeriksaan', 'desc') // Mengurutkan berdasarkan tanggal pemeriksaan terbaru
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
            return redirect()->route('dataKesehatan.index')->with('error', 'Data tidak ditemukan!');
        }
    
        // Menghitung umur dari tanggal lahir pengguna
        $tanggalLahir = $latestDataPerMonth->first()->pengguna->tanggal_lahir; // Ambil tanggal lahir dari data pengguna
        $umur = Carbon::parse($tanggalLahir)->age; // Menggunakan Carbon untuk menghitung umur
    
        // Kembalikan view dengan data yang ditampilkan
        return view('layouts.Data-kesehatan.detail_kesehatan', compact('latestDataPerMonth', 'umur'));
    }
    
    // Menampilkan halaman edit untuk data kesehatan
    public function edit($nik, $tanggal_pemeriksaan)
{
    // Get the data by NIK and tanggal_pemeriksaan
    $data = DataKesehatan::where('nik', $nik)
                        ->where('tanggal_pemeriksaan', $tanggal_pemeriksaan)
                        ->first();
    
    // Return the view with the data to edit
    return view('layouts.Data-kesehatan.edit_kesehatan', compact('data'));
}

    
public function update(Request $request, $nik, $tanggal_pemeriksaan)
{
    // Validate the input
    $request->validate([
        'tanggal_pemeriksaan' => 'required|date',
        'umur' => 'required|integer',
        'tinggi_badan' => 'required|numeric',
        'berat_badan' => 'required|numeric',
        'gula_darah' => 'required|numeric',
        'lingkar_pinggang' => 'required|numeric',
        'tensi_darah' => 'required|string|max:255',
        'riwayat_keluarga_diabetes' => 'required|string|in:Ya,Tidak',
    ]);

    // Update the data based on NIK and tanggal_pemeriksaan
    DataKesehatan::where('nik', $nik)
                 ->where('tanggal_pemeriksaan', $tanggal_pemeriksaan)
                 ->update([
                     'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
                     'umur' => $request->umur,
                     'tinggi_badan' => $request->tinggi_badan,
                     'berat_badan' => $request->berat_badan,
                     'gula_darah' => $request->gula_darah,
                     'lingkar_pinggang' => $request->lingkar_pinggang,
                     'tensi_darah' => $request->tensi_darah,
                     'riwayat_keluarga_diabetes' => $request->riwayat_keluarga_diabetes,
                 ]);

                 return redirect()->route('dataKesehatan.show', ['nik' => $nik])
                 ->with('success', 'Data kesehatan dengan NIK ' . $nik . ' berhasil diperbarui!');
}
    

}
