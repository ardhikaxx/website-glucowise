<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKesehatan;
use Illuminate\Http\Request;

class RiwayatKesehatanController extends Controller
{
    // Menampilkan daftar Riwayat Kesehatan
    public function index()
    {
        // Mengambil 10 data pertama dari Riwayat Kesehatan
        $riwayatKesehatan = RiwayatKesehatan::paginate(10);  // Pagination jika diperlukan
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
        // Validasi data
        $request->validate([
            'nomor_kk' => 'required|unique:riwayat_kesehatan,nomor_kk',
            'ibu' => 'required',
            'ayah' => 'required',
            'telepon' => 'required',
        ]);

        // Menyimpan data ke dalam database
        RiwayatKesehatan::create($request->all());

        // Redirect setelah data berhasil disimpan
        return redirect()->route('riwayatKesehatan.index')->with('success', 'Data Riwayat Kesehatan berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit data Riwayat Kesehatan
    public function edit($nomor_kk)
    {
        $data = RiwayatKesehatan::findOrFail($nomor_kk);  // Mencari data berdasarkan nomor KK
        return view('riwayatKesehatan.edit', compact('data'));
    }

    // Mengupdate data Riwayat Kesehatan
    public function update(Request $request, $nomor_kk)
    {
        // Validasi data
        $request->validate([
            'ibu' => 'required',
            'ayah' => 'required',
            'telepon' => 'required',
        ]);

        // Update data di database
        $data = RiwayatKesehatan::findOrFail($nomor_kk);
        $data->update($request->all());

        // Redirect setelah data berhasil diupdate
        return redirect()->route('riwayatKesehatan.index')->with('success', 'Data Riwayat Kesehatan berhasil diperbarui!');
    }

    // Menampilkan detail data Riwayat Kesehatan
    public function show($nomor_kk)
    {
        $data = RiwayatKesehatan::findOrFail($nomor_kk);
        return view('riwayatKesehatan.show', compact('data'));
    }

    // Menghapus data Riwayat Kesehatan
    public function destroy($nomor_kk)
    {
        $data = RiwayatKesehatan::findOrFail($nomor_kk);
        $data->delete();

        return redirect()->route('riwayatKesehatan.index')->with('success', 'Data Riwayat Kesehatan berhasil dihapus!');
    }

    // Pencarian data Riwayat Kesehatan
    public function search(Request $request)
    {
        $search = $request->input('search');
        $riwayatKesehatan = RiwayatKesehatan::where('nomor_kk', 'like', "%$search%")
                                            ->orWhere('ibu', 'like', "%$search%")
                                            ->orWhere('ayah', 'like', "%$search%")
                                            ->paginate(10);  // Paginate search results

        return view('riwayatKesehatan.index', compact('riwayatKesehatan'));
    }
}
