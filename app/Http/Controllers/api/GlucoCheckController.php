<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataKesehatan;
use App\Models\RiwayatKesehatan;
use Illuminate\Support\Facades\Validator;

class GlucoCheckController extends Controller
{
    // Method untuk menambahkan data kesehatan
    public function addCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|exists:pengguna,nik',
            'tanggal_pemeriksaan' => 'required|date',
            'riwayat_keluarga_diabetes' => 'required|in:Ya,Tidak',
            'umur' => 'required|integer|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'berat_badan' => 'required|numeric|min:0',
            'gula_darah' => 'required|numeric|min:0',
            'lingkar_pinggang' => 'required|numeric|min:0',
            'tensi_darah' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Simpan data kesehatan
        $data = DataKesehatan::create($request->all());

        // Buat riwayat kesehatan dengan status default "Dalam proses"
        $riwayat = RiwayatKesehatan::create([
            'id_data' => $data->id_data,
            'id_admin' => null, // Admin belum mengubah status
            'kategori_risiko' => 'Dalam proses',
            'catatan' => '',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data kesehatan berhasil ditambahkan',
            'data' => $data,
            'riwayat' => $riwayat,
        ], 201);
    }

    // Method untuk mengambil riwayat kesehatan berdasarkan NIK
    public function getHistory($nik)
    {
        $data = DataKesehatan::where('nik', $nik)
            ->with('riwayatKesehatan')
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }

    // Method untuk mengambil status risiko berdasarkan id_data
    public function getStatus($id_data)
    {
        $riwayat = RiwayatKesehatan::where('id_data', $id_data)->first();

        if (!$riwayat) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $riwayat,
        ], 200);
    }
}