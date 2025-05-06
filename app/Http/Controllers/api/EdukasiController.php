<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Edukasi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EdukasiController extends Controller
{
    /**
     * Mengambil semua data edukasi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Ambil data dengan pagination untuk menghindari load data yang terlalu besar
            $edukasi = Edukasi::with('admin')
                ->orderBy('tanggal_publikasi', 'desc')
                ->get();
    
            // Tambahkan URL gambar penuh dengan cara yang lebih aman
            $edukasi->transform(function ($item) {
                $item->gambar_url = $this->getSafeImageUrl($item->gambar);
                return $item;
            });
    
            return response()->json([
                'status' => true,
                'message' => 'Data edukasi berhasil diambil',
                'data' => $edukasi
            ], 200);

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error fetching edukasi data: ' . $e->getMessage());
            
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data edukasi',
                'error' => env('APP_DEBUG') ? $e->getMessage() : 'Terjadi kesalahan server'
            ], 500);
        }
    }

    /**
     * Mendapatkan URL gambar yang aman
     *
     * @param string|null $path
     * @return string|null
     */
    private function getSafeImageUrl($path)
    {
        if (empty($path)) {
            return null;
        }

        // Jika path sudah merupakan URL lengkap, kembalikan langsung
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Gunakan Storage facade untuk path lokal
        if (Storage::exists($path)) {
            return Storage::url($path);
        }

        // Fallback ke url() helper jika path relatif
        return url($path);
    }
}