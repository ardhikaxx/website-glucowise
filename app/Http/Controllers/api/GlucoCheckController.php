<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataKesehatan;
use Illuminate\Support\Facades\Validator;

class GlucoCheckController extends Controller
{
    public function addCheck(Request $request)
    {
        // Validasi input
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
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Simpan data ke database
        $data = DataKesehatan::create($request->all());

        return response()->json([
            'message' => 'Data kesehatan berhasil ditambahkan',
            'data' => $data,
        ], 201);
    }
}