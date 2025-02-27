<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EdukasiController extends Controller
{
    // Menampilkan daftar edukasi
    public function index(Request $request)
{
    // Ambil parameter pencarian dari request
    $search = $request->input('search');

    // Query untuk mengambil data edukasi dengan pencarian berdasarkan judul atau isi
    $dataEdukasi = Edukasi::when($search, function($query) use ($search) {
        return $query->where('judul', 'like', '%' . $search . '%')
                     ->orWhere('isi', 'like', '%' . $search . '%');
    })
    ->paginate(10);  // Menambahkan paginasi untuk hasil pencarian

    return view('layouts.Edukasi.edukasi', compact('dataEdukasi'));
}

    // Menampilkan form untuk membuat edukasi baru
    public function create()
    {
        return view('layouts.Edukasi.tambah');
    }

    // Menyimpan data edukasi baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Menyimpan gambar
        $imagePath = $request->file('gambar')->store('public/images/edukasi');

        // Menyimpan data edukasi
        Edukasi::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => basename($imagePath),
        ]);

        // Mengarahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('edukasi.index')->with('success', 'Edukasi berhasil ditambahkan');
    }

    

    // Menampilkan detail edukasi
    public function show($id)
    {
        $edukasi = Edukasi::findOrFail($id);
        return view('edukasi.show', compact('edukasi'));
    }

    // Menampilkan form untuk mengedit edukasi
    public function edit($id)
    {
        $dataEdukasi = Edukasi::findOrFail($id);  // Mengambil data berdasarkan ID
        return view('layouts.Edukasi.edit', compact('dataEdukasi'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        $dataEdukasi = Edukasi::findOrFail($id);
    
        // Update data edukasi
        $dataEdukasi->judul = $request->judul;
        $dataEdukasi->isi = $request->isi;
    
        // Update gambar jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            Storage::delete('public/images/edukasi/' . $dataEdukasi->gambar);
    
            // Simpan gambar baru
            $imagePath = $request->file('gambar')->store('public/images/edukasi');
            $dataEdukasi->gambar = basename($imagePath);
        }
    
        $dataEdukasi->save(); // Simpan perubahan
    
        return redirect()->route('edukasi.index')->with('success', 'Edukasi berhasil diperbarui');
    }
    

    // Menghapus data edukasi
    public function destroy($id)
    {
        $edukasi = Edukasi::findOrFail($id);

        // Menghapus gambar
        Storage::delete('public/images/' . $edukasi->gambar);

        // Menghapus data edukasi
        $edukasi->delete();

        return redirect()->route('edukasi.index')->with('success', 'Edukasi berhasil dihapus');
    }
}
