<?php
namespace App\Http\Controllers;

use App\Models\DataKesehatan;
use Illuminate\Http\Request;

class DataKesehatanController extends Controller
{
    // Menampilkan halaman daftar data kesehatan
    public function index()
    {
        $dataKesehatan = DataKesehatan::paginate(10); // Menampilkan 10 data per halaman
        return view('layouts.Data-kesehatan.data_kesehatan', compact('dataKesehatan')); // Mengirim data ke view
    }
    public function search(Request $request)
    {
        $search = $request->get('search');
        $dataKesehatan = DataKesehatan::where('nomor_kk', 'like', "%$search%")
                                        ->orWhere('ibu', 'like', "%$search%")
                                        ->orWhere('ayah', 'like', "%$search%")
                                        ->orWhere('telepon', 'like', "%$search%")
                                        ->paginate(10);
    
        return view('layouts.Data-kesehatan.data_kesehatan', compact('dataKesehatan'));
    }
    // Menampilkan halaman detail data kesehatan
    public function show($nomor_kk)
    {
        // Ambil data berdasarkan nomor KK
        $data = DataKesehatan::where('nomor_kk', $nomor_kk)->first();
        
        // Jika data tidak ditemukan, redirect atau tampilkan error
        if (!$data) {
            return redirect()->route('dataKesehatan.index')->with('error', 'Data tidak ditemukan!');
        }
    
        // Kembalikan view dengan data yang ditampilkan
        return view('layouts.Data-kesehatan.detail_kesehatan', compact('data'));
    }
    
    // Menampilkan halaman edit untuk data kesehatan
    public function edit($nomor_kk)
    {
        // Ambil data berdasarkan nomor KK
        $data = DataKesehatan::where('nomor_kk', $nomor_kk)->first();
        
        // Kembalikan view dengan data yang akan diedit
        return view('layouts.Data-kesehatan.edit_kesehatan', compact('data'));
    }
    
    public function update(Request $request, $nomor_kk)
    {
        // Validasi input
        $request->validate([
            'ibu' => 'required|string|max:255',
            'ayah' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'anak_1' => 'nullable|string|max:255',
            'anak_2' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
        ]);
    
        // Update data berdasarkan nomor KK
        DataKesehatan::where('nomor_kk', $nomor_kk)->update([
            'ibu' => $request->ibu,
            'ayah' => $request->ayah,
            'telepon' => $request->telepon,
            'anak_1' => $request->anak_1,
            'anak_2' => $request->anak_2,
            'alamat' => $request->alamat,
        ]);
    
        // Redirect setelah berhasil
        return redirect()->route('dataKesehatan.index')->with('success', 'Data berhasil diperbarui!');
    }

}
