<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKesehatan;
use Illuminate\Http\Request;

class RiwayatKesehatanController extends Controller
{
    // Menampilkan daftar Riwayat Kesehatan
    public function index()
    {
        $riwayatKesehatan = RiwayatKesehatan::paginate(10);  // Menampilkan data dengan pagination
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

    // Menampilkan form untuk mengedit data Riwayat Kesehatan
    public function edit($nomor_kk)
    {
        // Ambil data berdasarkan nomor KK
       
        $data = RiwayatKesehatan::where('nomor_kk', $nomor_kk)->first();
        
        // Kembalikan view dengan data yang akan diedit
        return view('layouts.Riwayat-kesehatan.edit_riwayat', compact('data'));
        
    }

    // Mengupdate data Riwayat Kesehatan
    public function update(Request $request, $nomor_kk)
    {
        // Validasi input form
        $request->validate([
            'ibu' => 'required',
            'ayah' => 'required',
            'telepon' => 'required',
            'deskripsi' => 'required',
            'dokter' => 'required',
            'diagnosa' => 'required',
            'pengobatan' => 'required',
        ]);

        // Cari data berdasarkan nomor KK dan update
        $data = RiwayatKesehatan::findOrFail($nomor_kk);
        $data->update($request->all());

        // Redirect setelah sukses
        return redirect()->route('riwayatKesehatan.index')->with('success', 'Data Riwayat Kesehatan berhasil diperbarui!');
    }

    // Menampilkan detail data Riwayat Kesehatan
    public function show($nomor_kk)
    {
        // Ambil data berdasarkan nomor KK
        $data = RiwayatKesehatan::where('nomor_kk', $nomor_kk)->first();

        // Jika data tidak ditemukan
        if (!$data) {
            return redirect()->route('riwayatKesehatan.index')->with('error', 'Data tidak ditemukan!');
        }

        // Kembalikan view dengan data yang ditampilkan
        return view('layouts.Riwayat-kesehatan.detail_riwayat', compact('data'));
    }

    // Menghapus data Riwayat Kesehatan
    public function destroy($nomor_kk)
    {
        // Cari data berdasarkan nomor KK dan hapus
        $data = RiwayatKesehatan::findOrFail($nomor_kk);
        $data->delete();

        // Redirect setelah data dihapus
        return redirect()->route('riwayatKesehatan.index')->with('success', 'Data Riwayat Kesehatan berhasil dihapus!');
    }

    // Pencarian data Riwayat Kesehatan
    public function search(Request $request)
    {
        // Ambil input pencarian
        $search = $request->input('search');

        // Cari data berdasarkan pencarian
        $riwayatKesehatan = RiwayatKesehatan::where('nomor_kk', 'like', "%$search%")
                                            ->orWhere('ibu', 'like', "%$search%")
                                            ->orWhere('ayah', 'like', "%$search%")
                                            ->paginate(10);  // Paginate search results

        // Tampilkan hasil pencarian
        return view('riwayatKesehatan.index', compact('riwayatKesehatan'));
    }
}
