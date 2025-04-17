<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatKesehatan; // Pastikan model yang sesuai digunakan

class RekamMedisController extends Controller
{
    // Method untuk menangani pencarian
    public function search(Request $request)
    {
        // Ambil query pencarian dari input
        $search = $request->get('search');

        // Cari data riwayat kesehatan berdasarkan pencarian, termasuk mencari pada tabel pengguna
        $riwayatKesehatan = RiwayatKesehatan::with('dataKesehatan.pengguna')
            ->when($search, function ($query, $search) {
                // Menambahkan kondisi pencarian untuk 'gula_darah' dan 'nama_lengkap'
                return $query->whereHas('dataKesehatan', function($query) use ($search) {
                    $query->whereHas('pengguna', function($query) use ($search) {
                        $query->where('nama_lengkap', 'like', "%$search%");
                    });
                })
                ->orWhereHas('dataKesehatan', function($query) use ($search) {
                    $query->where('gula_darah', 'like', "%$search%");
                });
            })
            ->paginate(10); // Menampilkan 10 data per halaman

        // Menentukan pesan jika data tidak ditemukan
        $message = '';
        if ($riwayatKesehatan->isEmpty()) {
            $message = 'Data dengan kata kunci "' . $search . '" tidak ditemukan.';
        }

        // Kirim data dan pesan ke view
        return view('layouts.Riwayat-kesehatan.riwayat_kesehatan', compact('riwayatKesehatan', 'message'));
    }
}
