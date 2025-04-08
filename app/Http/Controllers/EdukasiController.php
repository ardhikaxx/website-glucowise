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
        $search = $request->input('search');
    
        $dataEdukasi = Edukasi::when($search, function($query) use ($search) {
            return $query->where('judul', 'like', '%' . $search . '%')
                         ->orWhere('deskripsi', 'like', '%' . $search . '%');
        })
        ->paginate(10);
    
        return view('layouts.Edukasi.edukasi', compact('dataEdukasi'));
    }

    // Menampilkan form untuk membuat atau mengedit edukasi
    public function createOrEdit($id_edukasi = null)
    {
        $dataEdukasi = $id_edukasi ? Edukasi::findOrFail($id_edukasi) : new Edukasi();
        return view('layouts.Edukasi.edit', compact('dataEdukasi'));
    }

    // Menyimpan data edukasi baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'kategori' => 'required|in:Dasar Diabetes,Manajemen Diabetes',
        ]);
    
        // Menyimpan gambar jika ada
        $imagePath = null;
        if ($request->hasFile('gambar')) {
            // Menyimpan gambar baru
            $category = strtolower(str_replace(' ', '', $request->kategori)); // Menghilangkan spasi dan membuat huruf kecil
            $imageFileName = $category . time() . '.' . $request->file('gambar')->getClientOriginalExtension();
    
            // Path lengkap untuk menyimpan gambar di folder lokal
            $imagePath = public_path('images/edukasi/' . $imageFileName);
    
            // Menyimpan gambar ke dalam folder 'public/images/edukasi'
            $request->file('gambar')->move(public_path('images/edukasi'), $imageFileName);
        }
    
        // Menyimpan data edukasi
        Edukasi::create([
            'id_admin' => "1", // Assumed auth handling
            'kategori' => $request->kategori,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $imagePath ? 'images/edukasi/' . $imageFileName : null,
            'tanggal_publikasi' => now(),
        ]);
    
        return redirect()->route('edukasi.index')->with('success', 'Edukasi berhasil ditambahkan');
    }

    // Mengupdate data edukasi
    public function update(Request $request, $id_edukasi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'kategori' => 'required|in:Dasar Diabetes,Manajemen Diabetes',
        ]);
    
        $dataEdukasi = Edukasi::findOrFail($id_edukasi);
    
        // Update data edukasi
        $dataEdukasi->judul = $request->judul;
        $dataEdukasi->deskripsi = $request->deskripsi;
        $dataEdukasi->kategori = $request->kategori;
    
        // Update gambar jika ada
        if ($request->hasFile('gambar')) {
            // Menyimpan gambar baru
            $category = strtolower(str_replace(' ', '', $request->kategori)); // Menghilangkan spasi dan membuat huruf kecil
            $imageFileName = $category . $dataEdukasi->id_edukasi . '.' . $request->file('gambar')->getClientOriginalExtension();
    
            // Path lengkap untuk menyimpan gambar di folder lokal
            $imagePath = public_path('images/edukasi/' . $imageFileName);
    
            // Menyimpan gambar ke dalam folder 'public/images/edukasi'
            $request->file('gambar')->move(public_path('images/edukasi'), $imageFileName);
    
            // Menyimpan nama gambar dengan path relatif untuk disimpan di database
            $dataEdukasi->gambar = 'images/edukasi/' . $imageFileName;
        }
    
        // Simpan perubahan
        $dataEdukasi->save();
    
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

