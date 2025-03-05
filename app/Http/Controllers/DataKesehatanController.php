<?php
namespace App\Http\Controllers;

use App\Models\DataKesehatan;
use Illuminate\Http\Request;

class DataKesehatanController extends Controller
{
    // Menampilkan halaman daftar data kesehatan
    public function index()
{
    // Mengambil data kesehatan beserta relasi dengan pengguna
    $dataKesehatan = DataKesehatan::with('pengguna')->paginate(10); // Menampilkan 10 data per halaman dan mengambil data pengguna

    return view('layouts.Data-kesehatan.data_kesehatan', compact('dataKesehatan')); // Mengirim data ke view
}

public function search(Request $request)
{
    // Ambil query pencarian dari input
    $search = $request->get('search');

    // Cari data kesehatan berdasarkan pencarian, termasuk mencari pada tabel pengguna
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

    // Kirim data dan pesan ke view
    return view('layouts.Data-kesehatan.data_kesehatan', compact('dataKesehatan', 'message'));
}



    // Menampilkan halaman detail data kesehatan
    public function show($nik)
{
    // Ambil data berdasarkan NIK
    $data = DataKesehatan::with('pengguna') // Mengambil data kesehatan beserta relasi dengan pengguna
                          ->where('nik', $nik) // Menggunakan nik, bukan nomor_kk
                          ->first();
    
    // Jika data tidak ditemukan, redirect atau tampilkan error
    if (!$data) {
        return redirect()->route('dataKesehatan.index')->with('error', 'Data tidak ditemukan!');
    }

    // Kembalikan view dengan data yang ditampilkan
    return view('layouts.Data-kesehatan.detail_kesehatan', compact('data'));
}

    // Menampilkan halaman edit untuk data kesehatan
    public function edit($nik)
    {
        // Ambil data berdasarkan nomor KK
        $data = DataKesehatan::where('nik', $nik)->first();
        
        // Kembalikan view dengan data yang akan diedit
        return view('layouts.Data-kesehatan.edit_kesehatan', compact('data'));
    }
    
    public function update(Request $request, $nik)
    {
        // Validasi input
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
    
        // Update data berdasarkan NIK
        DataKesehatan::where('nik', $nik)->update([
            'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
            'umur' => $request->umur,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'gula_darah' => $request->gula_darah,
            'lingkar_pinggang' => $request->lingkar_pinggang,
            'tensi_darah' => $request->tensi_darah,
            'riwayat_keluarga_diabetes' => $request->riwayat_keluarga_diabetes,
        ]);
    
        // Redirect setelah berhasil dengan flash message
        return redirect()->route('dataKesehatan.index')->with('success', 'Data kesehatan dengan NIK ' . $nik . ' berhasil diperbarui!');
    }
    

}
