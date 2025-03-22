<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKesehatan;
use Illuminate\Http\Request;

class RiwayatKesehatanController extends Controller
{
    // Menampilkan daftar Riwayat Kesehatan
    public function index()
    {
        // Ambil data Riwayat Kesehatan dengan relasi yang diperlukan (DataKesehatan dan Pengguna)
        $riwayatKesehatan = RiwayatKesehatan::with(['dataKesehatan.pengguna'])->paginate(10);
        return view('layouts.Riwayat-kesehatan.riwayat_kesehatan', compact('riwayatKesehatan'));
    }

    // Menampilkan form untuk menambah data Riwayat Kesehatan
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



    // Mengupdate data Riwayat Kesehatan berdasarkan NIK
    // Mengupdate data Riwayat Kesehatan berdasarkan id_riwayat
    public function update(Request $request, $id_riwayat)
    {
        // Validasi input
        $request->validate([
            'kategori_risiko' => 'required|in:Rendah,Sedang,Tinggi',
            'catatan' => 'nullable|string',  // Ganti dengan 'catatan' yang benar
        ]);
    
        // Cari data berdasarkan id_riwayat dan update
        $data = RiwayatKesehatan::findOrFail($id_riwayat);
    
        // Simpan perubahan
        $data->update([
            'kategori_risiko' => $request->kategori_risiko,
            'catatan' => $request->catatan, // Perbaiki nama kolom menjadi 'catatan'
        ]);
    
        // Flash message untuk memberi tahu pengguna
        return redirect()->route('riwayatKesehatan.index')->with('success', 'Riwayat Kesehatan berhasil diperbarui!');
    }
    


    


    // Menampilkan detail data Riwayat Kesehatan berdasarkan NIK
    public function show($nik)
    {
        // Ambil data RiwayatKesehatan berdasarkan NIK melalui relasi DataKesehatan
        $data = RiwayatKesehatan::whereHas('dataKesehatan', function($query) use ($nik) {
            $query->where('nik', $nik);
        })->first();

        // Jika data tidak ditemukan
        if (!$data) {
            return redirect()->route('riwayatKesehatan.index')->with('error', 'Data tidak ditemukan!');
        }

        // Kembalikan view dengan data yang ditampilkan
        return view('layouts.Riwayat-kesehatan.detail_riwayat', compact('data'));
    }

    // Pencarian data Riwayat Kesehatan
    public function search(Request $request)
    {
        $search = $request->get('search'); // Mendapatkan nilai pencarian
        $riwayatKesehatan = RiwayatKesehatan::where('nomor_kk', 'like', "%$search%")
            ->orWhere('ibu', 'like', "%$search%")
            ->orWhere('ayah', 'like', "%$search%")
            ->orWhere('telepon', 'like', "%$search%")
            ->orWhere('deskripsi', 'like', "%$search%")
            ->orWhere('diagnosa', 'like', "%$search%")
            ->orWhere('pengobatan', 'like', "%$search%")
            ->orWhere('catatan_lainnya', 'like', "%$search%")
            ->paginate(10);

        // Return hasil pencarian
        return view('layouts.Riwayat-kesehatan.riwayat_kesehatan', compact('riwayatKesehatan'));
    }
}
