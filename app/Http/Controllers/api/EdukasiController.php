<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Edukasi;

class EdukasiController extends Controller
{
    // Fungsi untuk mengambil semua data edukasi
    public function index()
    {
        $edukasi = Edukasi::with('admin')->orderBy('tanggal_publikasi', 'desc')->get();
    
        // Tambahkan URL gambar penuh
        $edukasi->transform(function ($item) {
            $item->gambar_url = $item->gambar ? url($item->gambar) : null;
            return $item;
        });
    
        return response()->json([
            'success' => true,
            'message' => 'Data edukasi berhasil diambil',
            'data' => $edukasi
        ], 200);
    }
    
}
